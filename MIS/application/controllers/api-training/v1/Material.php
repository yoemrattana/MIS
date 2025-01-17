<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Material extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();

		writeApiInput();
	}

	public function filter_get()
    {
		$units = [
			'MIS' => 'របៀបប្រើប្រាស់កម្មវិធីរាយការណ៍គ្រុនចាញ់',
			'Education' => 'អប់រំសុខភាព',
			'VMW' => 'អ្នកស្ម័គ្រចិត្តភូមិព្យាបាលជំងឺគ្រុនចាញ់',
		];

		$categories = [
			'lesson' => 'Lesson',
			'Guideline' => 'Guideline',
			'SOP' => 'SOP',
		];

		$rs['unit'] =$units;
		$rs['category'] =$categories;

        $response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> $rs
		];

		$this->response($response);
    }

	public function list_get()
	{
		$audience   = $this->get('audience');
		$category   = $this->get('category');
		$place_code = $this->get('place_code');
		$unit = $this->get('unit');

		if ( strlen( $place_code ) == 10 ) $audience = 'VMW';
		else if ( strlen ( $place_code ) == 6 ) $audience = 'HC';
		else if ( strlen ( $place_code ) == 4 ) $audience = 'OD';

		if ( strlen( $place_code ) == 4 ) $rs = $this->getODMaterial($place_code, $category, $audience, $unit);
		else if ( strlen( $place_code ) == 6 ) $rs = $this->getHCMaterial($place_code, $category, $audience, $unit);
		else if ( strlen ( $place_code  ) == 10 ) $rs = $this->getVMWMaterial($place_code, $category, $audience, $unit);

		array_walk($rs, function (&$a, $k) {
		    $a['Source'] = $_SERVER['SERVER_NAME'] . '/media/Training/' . $a['Source'];
		    $a['Thumbnail'] = $_SERVER['SERVER_NAME'] . '/media/Training/Thumbnail/' . $a['Thumbnail'];
			$a['Comments'] = $this->getComments( $a['Material_ID'] );
		    unset($a['InitTime'], $a['InitUser'], $a['IsActive']);
		});

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> $rs
		];

		$this->response($response);
	}

	private function getComments( $materialId )
	{
		$this->db->select('tblTrainMaterialComment.*, ISNULL(IsRead, 0) as IsRead');
		return $this->db->get_where('tblTrainMaterialComment', ['Material_ID' => $materialId])->result_array();
	}

	private function getVMWMaterial( $place_code, $category, $audience, $unit )
	{
		$where =  " ";
		if ( !empty( $category ) ) {
		    $where .= " and Category = '{$category}'";
		}

		if ( !empty($unit) ) {
            $where .= " and Unit = '{$unit}'";
        }

		$sql = "select tblTrainMaterial.Rec_ID as Material_ID, Title, Source, Type, Category, Unit, Code_Vill_T, Thumbnail,YouTube, ISNULL(IsRead, 0) as IsRead
				from tblTrainMaterial, tblCensusVillage as a
				left join tblTrainMaterialLog as b on b.Code_Place = a.Code_Vill_T
				where Code_Vill_T = '{$place_code}' and Audience = '{$audience}' $where";

		return $this->db->query( $sql )->result_array();
	}

	private function getHCMaterial( $place_code, $category, $audience, $unit )
	{
		$where =  " ";
		if ( !empty( $category ) ) {
			$where .= " and Category = '{$category}'";
		}

		if ( !empty($unit) ) {
            $where .= " and Unit = '{$unit}'";
        }

		$sql = "select tblTrainMaterial.Rec_ID as Material_ID, Title, Source, Type, Category, Unit, Code_Facility_T, Thumbnail,YouTube, ISNULL(IsRead, 0) as IsRead
				from tblTrainMaterial, tblHFCodes as a
				left join tblTrainMaterialLog as b on b.Code_Place = a.Code_Facility_T
				where Code_Facility_T = '{$place_code}' and Audience = '{$audience}' $where";

		return $this->db->query( $sql )->result_array();
	}

	private function getODMaterial( $place_code, $category, $audience, $unit )
	{
		$where =  " ";
		if ( !empty( $category ) ) {
			$where .= " and Category = '{$category}'";
		}

		if ( !empty($unit) ) {
            $where .= " and Unit = '{$unit}'";
        }

		$sql = "select tblTrainMaterial.Rec_ID as Material_ID, Title, Source, Type, Category,Unit, Code_OD_T, Thumbnail,YouTube, ISNULL(IsRead, 0) as IsRead
				from tblTrainMaterial, tblOD as a
				left join tblTrainMaterialLog as b on b.Code_Place = a.Code_OD_T
				where Code_OD_T = '{$place_code}' and Audience = '{$audience}' $where";

		return $this->db->query( $sql )->result_array();
	}

	public function update_status_post()
	{
		$submit = $this->post();

		$where = $submit;
		unset($where['IsRead']);
		$this->db->delete('tblTrainMaterialLog', $where);

		$this->db->insert('tblTrainMaterialLog', $submit);

		$response = [
			"code"		=> 200,
			"message"	=> "success",
			"data"		=> []
		];

		$this->response($response);
	}
}