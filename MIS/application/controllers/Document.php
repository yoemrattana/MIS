<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'Doc';
		$data['main'] = 'document_view';
		$this->load->view('layoutV3', $data);
	}

    public function getList()
    {
        $rs = $this->db->order_by('PublishYear DESC, Title')->get('tblDocument')->result();

		$this->output->set_output(json_encode($rs));
    }

    public function save()
	{
		if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');

		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

		$extension = '.pdf';
		$uuid = GUID();

		if (isset( $submit['File']) && $submit['File'] != null && !strContain($submit['File'], '.pdf')) {
			$dir = FCPATH.'/media/Documents';
			if (!file_exists($dir)) mkdir($dir);
			$filename = $uuid . $extension;
			file_put_contents($dir.'/'.$filename, base64_decode($submit['File']));
			$submit['FileName'] = $filename;
		}

		if ( isset( $submit['Thumbnail']) && $submit['Thumbnail'] != null && !strContain($submit['Thumbnail'], '.jpg') ) {
			$dir = FCPATH.'/media/Documents/Thumbnail/';
			if (!file_exists($dir)) mkdir($dir);
			$filename = 'thum_' . $uuid . '.jpg';
			file_put_contents($dir.'/'.$filename, base64_decode($submit['Thumbnail']));
			$submit['Thumbnail'] = $filename;
		}

		$rec_id = $submit['Rec_ID'];
		unset($submit['Rec_ID'], $submit['File']);
		if ( empty( $rec_id ) ) {
			$submit['InitTime'] = sqlNow();
			$submit['InitUser'] = $_SESSION['username'];
			$this->db->insert('tblDocument', $submit);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblDocument', $submit, ['Rec_ID' => $rec_id]);
		}

		$row = $this->db->get_where('tblDocument', ['Rec_ID'=> $rec_id])->row();
		$this->output->set_output(json_encode($row));
	}

    public function delete()
	{
		$rec_id = $this->input->post('rec_id');
		$source = $this->input->post('fileName');
		$thumbnail = $this->input->post('thumbnail');

		if ( file_exists( 'media/Training/'.$thumbnail ) ) unlink('media/Documents/Thumbnail/'.$thumbnail);
		if ( file_exists( 'media/Training/'.$source ) ) unlink('media/Documents/'.$source);

		$this->db->delete('tblDocument', ['Rec_ID'=>$rec_id]);
	}

}