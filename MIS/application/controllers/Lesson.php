<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson extends MY_Controller
{
	public function index()
	{
		$this->load->view('lesson/index.php');
	}

	public function detail($unit)
	{
        $data = [];
		$data['title'] = $unit;

        $sql = "select a.Type, a.Source,  a.Title, a.Category, a.Unit, b.Title as SubCat from tblTrainMaterial as a
                join tblTrainMaterialSubCat as b on a.SubCategory = b.Rec_ID
                where Unit = '$unit' and 'VMW' in (select * from dbo.Split(Audience))";

		$rs = $this->db->query($sql)->result_array();

        $data['vmws'] = $this->subCat($rs);

		$sql = "select a.Type, a.Source,  a.Title, a.Category, a.Unit, b.Title as SubCat from tblTrainMaterial as a
                join tblTrainMaterialSubCat as b on a.SubCategory = b.Rec_ID
                where Unit = '$unit' and 'HC' in (select * from dbo.Split(Audience))";

		$rs = $this->db->query($sql)->result_array();

        $data['hcs'] = $this->subCat($rs);

        $sql = "select a.Type, a.Source,  a.Title, a.Category, a.Unit, b.Title as SubCat from tblTrainMaterial as a
                join tblTrainMaterialSubCat as b on a.SubCategory = b.Rec_ID
                where Unit = '$unit' and 'OD' in (select * from dbo.Split(Audience))";

		$rs = $this->db->query($sql)->result_array();

        $data['ods'] = $this->subCat($rs);


        $sql = "select a.Type, a.Source,  a.Title, a.Category, a.Unit, b.Title as SubCat from tblTrainMaterial as a
                join tblTrainMaterialSubCat as b on a.SubCategory = b.Rec_ID
                where Unit = '$unit' and 'PHD' in (select * from dbo.Split(Audience))";

		$rs = $this->db->query($sql)->result_array();

        $data['phds'] = $this->subCat($rs);

		$this->load->view('lesson/detail.php', $data);
	}

    private function subCat($rs)
    {
        $sub = [];
        foreach($rs as $r){
            $sub[$r['SubCat']][] = $r;
        }
        return $sub;
    }
}