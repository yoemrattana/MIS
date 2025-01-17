<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Train extends MY_Controller
{
	public function index()
	{
		if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');

		$data['title'] = 'Training material';
		$data['main'] = 'train_view';

		$this->load->view('layoutV3', $data);
	}

	public function getList()
	{
		if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');;

        $rs['subCats'] = $this->db->get('tblTrainMaterialSubCat')->result();
		$rs['materials'] = $this->db->get('tblTrainMaterial')->result();

		$this->db->select('tblTrainMaterialComment.*');
		$this->db->join('tblTrainMaterial', 'tblTrainMaterialComment.Material_ID = tblTrainMaterial.Rec_ID');

		$rs['unreadComments'] = $this->getUnreadComment();

		$this->output->set_output(json_encode($rs));
	}

	private function getUnreadComment()
	{
		$sql = "select a.*, Code_Prov_N, Code_OD_T, Code_Place as Code_Facility_T from tblTrainMaterialComment as a
				join tblHFCodes as b on b.Code_Facility_T = a.Code_Place
				where IsRead = 0

				union all

				select a.*, Code_Prov_N, Code_OD_T, Code_Facility_T  from tblTrainMaterialComment as a
				join tblCensusVillage as b on b.Code_Vill_T = a.Code_Place
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				where IsRead = 0
				order by Rec_ID desc";

		return $this->db->query( $sql )->result();
	}

	public function save()
	{
		if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');

		$submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

		if ( $submit['Type'] == 'PDF' ) $extension = '.pdf';
		else if ( $submit['Type'] == 'Video') $extension = '.mp4';
		else $extension = '.pptx';

		$uuid = GUID();
		if (isset( $submit['File']) && $submit['File'] != null) {
			$dir = FCPATH.'/media/Training';
			if (!file_exists($dir)) mkdir($dir);
			$filename = $uuid . $extension;
			file_put_contents($dir.'/'.$filename, base64_decode($submit['File']));
			$submit['Source'] = $filename;
		}

		if ( isset( $submit['Thumbnail']) && $submit['Thumbnail'] != null && !strContain($submit['Thumbnail'], '.jpg') ) {
			$dir = FCPATH.'/media/Training/Thumbnail/';
			if (!file_exists($dir)) mkdir($dir);
			$filename = 'thum_' . $uuid . '.jpg';
			file_put_contents($dir.'/'.$filename, base64_decode($submit['Thumbnail']));
			$submit['Thumbnail'] = $filename;
		}

		$rec_id =  $submit['Rec_ID'];
		unset($submit['Rec_ID'], $submit['File']);
		if ( empty( $rec_id ) ) {
			$submit['InitTime'] = sqlNow();
			$submit['InitUser'] = $_SESSION['username'];
			$this->db->insert('tblTrainMaterial', $submit);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblTrainMaterial', $submit, ['Rec_ID' => $rec_id]);
		}

		$row = $this->db->get_where('tblTrainMaterial', ['Rec_ID'=> $rec_id])->row();
		$this->output->set_output(json_encode($row));
	}

    public function saveSubCat()
    {
        if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');

		$submit = $this->input->post('submit');
        $submit = json_decode($submit, true);

        $id = $submit['Rec_ID'];

        $this->db->delete('tblTrainMaterialSubCat', ['Rec_ID' => $id]);

        unset($submit['Rec_ID']);

        $this->db->insert('tblTrainMaterialSubCat', $submit);

        $rs = $this->db->get('tblTrainMaterialSubCat')->result();
		$this->output->set_output(json_encode($rs));
    }

	public function delete()
	{
		if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');

		$rec_id = $this->input->post('rec_id');
		$source = $this->input->post('source');
		$thumbnail = $this->input->post('thumbnail');

		if ( !empty($thumbnail) && file_exists( 'media/Training/'.$thumbnail ) ) unlink('media/Training/Thumbnail/'.$thumbnail);
		if ( !empty($source) && file_exists( 'media/Training/'.$source ) ) unlink('media/Training/'.$source);

		$this->db->delete('tblTrainMaterial', ['Rec_ID'=>$rec_id]);
	}

    public function deleteSubCat()
    {
        if (!isset($_SESSION['permiss']['Train Material'])) redirect('Home');

		$rec_id = $this->input->post('rec_id');

        $this->db->delete('tblTrainMaterialSubCat', ['Rec_ID'=>$rec_id]);
    }

	/*
	 *  comment
	 * */

	public function getComments()
	{
		$materialId = $this->input->post('material_id');

		$sql =  "select a.*, Code_Prov_N, Code_OD_T, Code_Place as Code_Facility_T from tblTrainMaterialComment as a
				join tblHFCodes as b on b.Code_Facility_T = a.Code_Place
				where Parent_ID is null and Material_ID = {$materialId}

				union all

				select a.*, Code_Prov_N, Code_OD_T, Code_Facility_T  from tblTrainMaterialComment as a
				join tblCensusVillage as b on b.Code_Vill_T = a.Code_Place
				join tblHFCodes as c on c.Code_Facility_T = b.HCCode
				where Parent_ID is null and Material_ID = {$materialId}
				order by Rec_ID desc";

		$rs = $this->db->query( $sql )->result_array();;

		array_walk($rs, function (&$a, $k) {
			$this->db->select('tblTrainMaterialComment.*, 0 as IsNew');
			$reply = $this->db->get_where('tblTrainMaterialComment', [ 'Parent_ID' => $a['Rec_ID'] ])->result_array();
			$a['Reply'] = $reply;
		});

		$this->output->set_output( json_encode( $rs ) );
	}

	public function saveReply()
	{
		$submit = $this->input->post('submit');
		$submit = json_decode( $submit, true );
		$submit['InitTime'] = sqlNow();
		$submit['IsRead'] = 0;
		unset($submit['IsNew'], $submit['Rec_ID']);

		$this->db->insert('tblTrainMaterialComment', $submit);
		$id = $this->db->insert_id();

		$this->output->set_output( json_encode( $id ) );
	}

	public function deleteComment()
	{
		$rec_id = $this->input->post('rec_id');

		$this->db->delete('tblTrainMaterialComment', ['Parent_ID' => $rec_id] );
		$this->db->delete('tblTrainMaterialComment', ['Rec_ID' => $rec_id] );
	}

	public function updateStatus()
	{
		$commentId = $this->input->post('comment_id');

		$this->db->update('tblTrainMaterialComment', ['IsRead' => 1], ['Rec_ID' => $commentId]);
	}
}