<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Token_model extends CI_Model
{
	//TODO remove
	public function getTokens($placeCode, $type = '')
	{
		if ($type == 'cmi_by_hc') return $this->getTokenCmiByHC($placeCode);
		if ($type == 'cmi_by_vmw') return $this->getTokenCmiByVMW($placeCode);
		if ($type == 'hc_by_vmw') return $this->getTokenHcByVmw($placeCode);
		if ($type == 'hc') return $this->getHcToken($placeCode);
		if ($type == 'vmw') return $this->getTokenVmw($placeCode);
		if ($type == 'admin') return $this->getTokenAdmin();
	}

	function getTokenCmiByHC($placeCode)
	{
		$sql = "with t as (
	                select * from tblHFCodes
               )

                select Token, Imei
                from (
	                select Imei, Token, Code_OD_Notification, Code_Prov_Notification from tblMalariaInfoToken as a
	                left join MIS_User as b on b.Us = a.Username
               ) as a
                join t as b on b.Code_Prov_N in (select * from dbo.Split(a.Code_Prov_Notification)) and (a.Code_OD_Notification = b.Code_OD_T or a.Code_OD_Notification = '')
				where Code_Facility_T = '{$placeCode}'";

		$rs = $this->db->query($sql)->result_array();
		$tokens = array_column($rs, 'Token');
		$imeis = array_column($rs, 'Imei');

		return [
			'tokens' => array_flatten($tokens),
			'imeis' => $imeis
		];
	}

	private function getTokenCmiByVMW($placeCode)
	{
		$sql = "with t as (
	            select a.Code_Vill_T, Code_Prov_T, Code_OD_T from tblCensusVillage as a
	            join tblHFCodes as b on a.HCCode = b.Code_Facility_T
           )

            select Token, Imei
            from (
	            select Imei, Token, Code_OD_Notification, Code_Prov_Notification from tblMalariaInfoToken as a
	            left join MIS_User as b on b.Us = a.Username
           ) as a
            join t as b on b.Code_Prov_T in (select * from dbo.Split(a.Code_Prov_Notification)) and (a.Code_OD_Notification = b.Code_OD_T or a.Code_OD_Notification = '')
				where Code_Vill_T = '{$placeCode}'";

		$rs = $this->db->query($sql)->result_array();
		$tokens = array_column($rs, 'Token');
		$imeis = array_column($rs, 'Imei');

		return [
			'tokens' => array_flatten($tokens),
			'imeis' => $imeis
		];
	}

	private function getTokenAdmin()
	{
		$sql = "select Imei, Token from tblMalariaInfoToken as a
				join MIS_User as b on b.Us = a.Username
				where Role in ('AU' , 'VICE DIRECTOR', 'DIRECTOR')";

		$rs		= $this->db->query($sql)->result_array();
		$tokens = array_column($rs, 'Token');
		$imeis  = array_column($rs, 'Imei');

		return [
			'tokens' => array_flatten($tokens),
			'imeis'  => $imeis
		];
	}

	//CMI Token
	public function getCMITokenImei($hfCode, $specie)
	{
		$sql = "with t as (
					select * from tblHFCodes
				)

				select Token, Imei
				from (
					select Imei, Token, Code_OD_Notification, Code_Prov_Notification from tblMalariaInfoToken as a
					join MIS_User as b on b.Us = a.Username and '{$specie}' in (select * from dbo.Split(b.Specie_Notification))
				) as a
				join t as b on b.Code_Prov_N in (select * from dbo.Split(a.Code_Prov_Notification)) and (a.Code_OD_Notification = b.Code_OD_T or a.Code_OD_Notification = '')
				where Code_Facility_T = '{$hfCode}'";

		$rs		= $this->db->query($sql)->result_array();
		$tokens = array_column($rs, 'Token');
		$imeis  = array_column($rs, 'Imei');

		return [
			'tokens' => array_flatten($tokens),
			'imeis'  => $imeis
		];
	}

	public function getChatId($HFCode, $specie)
	{
		$sql = "select a.ID from tblTelegramGroup as a
				join tblHFCodes as b on b.Code_Prov_N in (select * from dbo.Split(a.Code_Prov))
				and (b.Code_OD_T = a.Code_OD or a.Code_OD = '')
				and '{$specie}' in (select * from dbo.Split(a.Specie))
				where Code_Facility_T = '{$HFCode}' and a.IsActive=1";

		$ids = $this->db->query($sql)->result_array();
		return array_flatten($ids);
	}

	function getHcToken($hfCode)
	{
		$sql = "select Token from tblToken
				where CodePlace = '{$hfCode}'";
		$rs = $this->db->query($sql)->result_array();
		return array_flatten($rs);
	}

	private function getTokenHcByVmw($code_village)
	{
		$sql = "select Token from tblToken as a
				join tblCensusVillage as b on a.CodePlace = b.HCCode
				where Code_Vill_T = '{$code_village}'";
		$rs = $this->db->query($sql)->result_array();
		return array_flatten($rs);
	}

	private function getTokenVmw($code_village)
	{
		$sql = "select Token from tblToken
				where CodePlace = '{$code_village}'";
		$rs = $this->db->query($sql)->result_array();
		return array_flatten($rs);
	}
}