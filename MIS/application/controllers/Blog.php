<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{
	public function index()
	{
        if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = 'Blog';
		$data['main'] = 'blog_view';
		$this->load->view('layoutV3', $data);
	}

    public function getData()
    {
        $rs = $this->db->get('tblBlog')->result();
		$this->output->set_output( json_encode( $rs ) );
    }

    public function save()
    {
        $submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

        $uuid = GUID();
        if ( isset( $submit['Thumbnail']) && $submit['Thumbnail'] != null && !strContain($submit['Thumbnail'], '.jpg') ) {
			$dir = FCPATH.'/media/blog/';
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
			$this->db->insert('tblBlog', $submit);
			$rec_id = $this->db->insert_id();
		} else {
			$this->db->update('tblBlog', $submit, ['Rec_ID' => $rec_id]);
		}

		$row = $this->db->get_where('tblBlog', ['Rec_ID'=> $rec_id])->row();
		$this->output->set_output(json_encode($row));
    }

    public function delete()
	{
		$rec_id = $this->input->post('rec_id');
		$thumbnail = $this->input->post('thumbnail');

		if ( !empty($thumbnail) && file_exists( 'media/blog/'.$thumbnail ) ) unlink('media/blog/'.$thumbnail);

		$this->db->delete('tblBlog', ['Rec_ID'=>$rec_id]);
	}

}