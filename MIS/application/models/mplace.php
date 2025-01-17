<?php
class MPlace extends CI_Model
{
	public function getProvinces()
	{
		$data = array();
		$sql = "select Code_Prov_T,Name_Prov_E, Name_Prov_K from tblProvince ORDER BY Code_Prov_T";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0) {
			foreach ($Q->result_array() as $row) {
				$data[] = [
					"Code_Prov_T" => $row['Code_Prov_T'],
					"Name_Prov_E" => $row['Name_Prov_E'],
					"Name_Prov_K" => $row['Name_Prov_K']
				];
			}
		}
		return $data;
	}

	public function getDistricts($page_index=1)
	{
		$data = array();
		$offset = ($page_index -1) * 30;
		$sql = "select Code_Dist_T,Name_Dist_E, Name_Dist_K from tblDistrict  ORDER BY Code_Dist_T OFFSET ".$offset." ROWS FETCH NEXT 30 ROWS ONLY";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0) {
			foreach ($Q->result_array() as $row) {
				$data[] = [
					"Code_Dist_T" => $row['Code_Dist_T'],
					"Name_Dist_E" => $row['Name_Dist_E'],
					"Name_Dist_K" => $row['Name_Dist_K']
				];
			}
		}
		return $data;
	}

	public function getCommunes($page_index=1)
	{
		$data = array();
		$offset = ($page_index -1) * 30;
		$sql = "select Code_Comm_T,Name_Comm_E,Name_Comm_K from tblCommune ORDER BY Code_Comm_T OFFSET ".$offset." ROWS FETCH NEXT 30 ROWS ONLY";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0) {
			foreach ($Q->result_array() as $row) {
				$data[] = [
					"Code_Comm_T" => $row['Code_Comm_T'],
					"Name_Comm_E" => $row['Name_Comm_E'],
					"Name_Comm_K" => $row['Name_Comm_K']
				];
			}
		}
		return $data;
	}

	public function getVillages($page_index=1)
	{
		$data = array();
		$offset = ($page_index -1) * 30;
		$sql = "Select Code_Vill_T,Name_Vill_E,Name_Vill_K,HCCode,HaveVMW From tblCensusVillage  ORDER BY Code_Vill_T OFFSET ".$offset." ROWS FETCH NEXT 30 ROWS ONLY";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0) {
			foreach ($Q->result_array() as $row) {
				$data[] = [
					"Code_Vill_T" => $row['Code_Vill_T'],
					"Name_Vill_E" => $row['Name_Vill_E'],
					"Name_Vill_K" => $row['Name_Vill_K'],
					"HC_Code" => $row['HCCode'],
					"HaveVMW" => $row['HaveVMW']
				];
			}
		}
		return $data;
	}

	public function getODs($page_index=1)
	{
		$data = array();
		$offset = ($page_index -1) * 30;
		$sql = "select Code_OD_T,Name_OD_E,Name_OD_K from tblOD  ORDER BY Code_OD_T OFFSET ".$offset." ROWS FETCH NEXT 30 ROWS ONLY";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0) {
			foreach ($Q->result_array() as $row) {
				$data[] = [
					"Code_OD_T" => $row['Code_OD_T'],
					"Name_OD_E" => $row['Name_OD_E'],
					"Name_OD_K" => $row['Name_OD_K']
				];
			}
		}
		return $data;
	}

	public function getHCs($page_index=1)
	{
		$data = array();
		$offset = ($page_index -1) * 30;
		$sql = "select Code_Facility_T,Name_Facility_E,Name_Facility_K from tblHFCodes  ORDER BY Code_Facility_T OFFSET ".$offset." ROWS FETCH NEXT 30 ROWS ONLY";
		$Q = $this->db->query($sql);
		if ($Q->num_rows() > 0) {
			foreach ($Q->result_array() as $row) {
				$data[] = [
					"Code_Facility_T" => $row['Code_Facility_T'],
					"Name_Facility_E" => $row['Name_Facility_E'],
					"Name_Facility_K" => $row['Name_Facility_K']
				];
			}
		}
		return $data;
	}

	public function countDistrict(){
		$sql = "select Count(*) cnt from tblDistrict";
		$Q = $this->db->query($sql);
		$row = $Q->row_array();
		return $row['cnt'] ;
	}

	public function countCommune()
	{
		$sql = "select Count(*) cnt from tblCommune";
		$Q = $this->db->query($sql);
		$row = $Q->row_array();
		return $row['cnt'] ;
	}

	public function countVillage()
	{
		$sql = "select Count(*) cnt from tblCensusVillage";
		$Q = $this->db->query($sql);
		$row = $Q->row_array();
		return $row['cnt'] ;
	}

	public function countOD()
	{
		$sql = "select Count(*) cnt from tblOD";
		$Q = $this->db->query($sql);
		$row = $Q->row_array();
		return $row['cnt'] ;
	}

	public function countHC()
	{
		$sql = "select Count(*) cnt from tblHFCodes";
		$Q = $this->db->query($sql);
		$row = $Q->row_array();
		return $row['cnt'] ;
	}
}