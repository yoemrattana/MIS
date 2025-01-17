<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends MY_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['EVENT'])) redirect('Home');

		$data['title'] = 'Event';
		$data['main'] = 'event_view';
		$this->load->view('layout', $data);
	}

	public function getList()
    {
        $rs = $this->db->get('tblEvent')->result();
		$this->output->set_output(json_encode($rs));
    }

    public function deleteEvent()
	{
		$submit = $this->input->post('submit');

		$this->deleteFile($submit);

		$this->db->delete('tblEvent', ['Rec_ID' => $submit['Rec_ID']]);
	}

	private function deleteFile($submit)
    {
        foreach(['Logo', 'Backdrop', 'AgendaKH' , 'AgendaEN'] as $file) {
            if ( !empty($submit[$file]) && file_exists( 'media/Event/'.$submit[$file] ) ) unlink('media/Event/'.$submit[$file]);
        }
    }

	public function saveEvent()
    {
        $submit = $this->input->post('submit');

		$where['Rec_ID'] = $submit['Rec_ID'];
		unset($submit['Rec_ID']);

        $recId = uniqid();

		$submit['Logo'] = $this->proccessFile($submit,'Logo', '.png');
		$submit['BackdropEN'] = $this->proccessFile($submit,'BackdropEN', '.jpg');
		$submit['BackdropKH'] = $this->proccessFile($submit,'BackdropKH', '.jpg');
		$submit['AgendaEN'] = $this->proccessFile($submit,'AgendaEN', '.pdf');
		$submit['AgendaKH'] = $this->proccessFile($submit,'AgendaKH', '.pdf');

		if( empty( $where['Rec_ID'] ) ) {
            $submit['InitTime'] = sqlNow();
            $submit['InitUser'] = $_SESSION['username'];

            $submit['Rec_ID'] = $recId;

            $this->db->insert('tblEvent', $submit);
        } else {
            $submit['ModiTime'] = sqlNow();
            $submit['ModiUser'] = $_SESSION['username'];

            $this->db->update('tblEvent', $submit, $where);
        }

        $event = $this->getEvent($recId);

        $this->output->set_output(json_encode($event));
    }

    private function getEvent($recId)
    {
        return $this->db->get_where('tblEvent', ['Rec_ID' => $recId])->row();
    }

	public function proccessFile($submit, $file, $fileType)
    {
        if (isset($submit[$file]) && $submit[$file] != null && !strContain($submit[$file], $fileType)) {
			$dir = FCPATH.'/media/Event';
			if (!file_exists($dir)) mkdir($dir);
			$filename = GUID().$fileType;
			if($fileType == '.pdf') file_put_contents($dir.'/'.$filename, base64_decode($submit[$file]));
			else file_put_contents($dir.'/'.$filename, base64_decode(explode(',', $submit[$file])[1]));
			return $filename;
		}
		return $submit[$file];
    }

	public function getParticipants()
    {
		$sql = "select a.*, EventNameEN from tblEventParticipant as a
                join tblEvent as b on a.EventID = b.Rec_ID";
		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));

    }

    public function saveParticipant()
    {
        $submit = $this->input->post('submit');

		$where['Rec_ID'] = $submit['Rec_ID'];
		unset($submit['Rec_ID'], $submit['EventNameEN']);

        $recId= uniqid();

		if( empty( $where['Rec_ID'] ) ) {
            $submit['InitTime'] = sqlNow();
            $submit['InitUser'] = $_SESSION['username'];

            $submit['Rec_ID'] = $recId;

            $this->db->insert('tblEventParticipant', $submit);
        } else {
            $submit['ModiTime'] = sqlNow();
            $submit['ModiUser'] = $_SESSION['username'];

            $this->db->update('tblEventParticipant', $submit, $where);
        }

        $participant = $this->getParticipant($recId);
        $this->output->set_output(json_encode($participant));
    }

    private function getParticipant($recId)
    {
        $sql = "select a.*, EventNameEN from tblEventParticipant as a
                join tblEvent as b on a.EventID = b.Rec_ID where a.Rec_ID = '$recId'";
		return $this->db->query($sql)->row();
    }

    public function deleteParticipant()
	{
		$submit = $this->input->post('submit');

		$this->db->delete('tblEventParticipant', ['Rec_ID' => $submit['Rec_ID']]);
	}

    public function exportExcel()
    {
		$event = $this->input->post('event');

        $sql = "select a.*, EventNameEN from tblEventParticipant as a
                join tblEvent as b on a.EventID = b.Rec_ID where a.EventID = '$event'";
		$participants = $this->db->query($sql)->result_array();

		$folder = FCPATH . '/media/Event/';
		$template = $folder . "paticipants.xlsx";

		$this->load->library('PHPExcel');
		$excel = PHPExcel_IOFactory::load($template);
		$sheet = $excel->getActiveSheet();

        $r = 3;
        foreach( $participants as $participant ) {
            $c = 0;
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['ParticipantName']);
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['ParticipantPhone']);
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['ParticipantEmail']);
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['Organization']);
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['EventNameEN']);
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['WillAttend']);
            $sheet->setCellValueByColumnAndRow($c++,$r, $participant['Comment']);

            $r++;
        }

		ob_start();
		$writer = new PHPExcel_Writer_Excel2007($excel);
		$writer->save('php://output');
		header('Content-Length: ' . ob_get_length());
		//header('Content-Type: ' . get_mime_by_extension('.xlsx'));
		ob_end_flush();
    }
}