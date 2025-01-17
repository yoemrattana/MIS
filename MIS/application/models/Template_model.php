<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Template_model extends CI_Model
{
	public function get($template, $row)
	{
		if ($template == 'vmw_case') return $this->setCaseVMW($row);
		if ($template == 'foci_case') return $this->setFociCase($row);
		if ($template == 'cmi_case') return $this->getCmiCase($row);
		if ($template == 'reactive_case') return $this->setReactiveCase($row);
		if ($template == 'vmwhc_case') return $this->getCaseVmwHc($row);
		if ($template == 'foci_reminder') return $this->setFociReminder($row);
		if ($template == 'reactive_reminder') return $this->setReactiveReminder($row);
		if ($template == 'high_risk_village') return $this->setHighRiskVillage($row);
		if ($template == 'stock_out') return $this->setStockOut($row);
        if ($template == 'near_expired_stock') return $this->setNearExpiredStock($row);
		return false;
	}

	private function getCaseVmwHc($row)
	{
		$template = $this->getTemplate();
		$template = $template['CaseVmwHc'];

		$template = str_replace('{code}', $row['PatientCode'], $template);
		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{patient_phone}', $row['Phone'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);

		return $template;
	}

	private function setCaseVMW($row)
	{
		$template = $this->getTemplate();
		$template = $template['CmiCase'];

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{entry_by}', $row['EntryBy'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);
		$template = str_replace('{phone}', $row['Phone'], $template);

		return $template;
	}

	private function setFociCase($row)
	{
		$template = $this->getTemplate();
		$template = $template['FociCase'];

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{entry_by}', $row['EntryBy'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);
		$template = str_replace('{phone}', $row['Phone'], $template);

		return $template;
	}

	private function getCmiCase($row)
	{
		$template = $this->getTemplate('CmiCase');

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{entry_by}', $row['EntryBy'], $template);
        if( empty($row['OldDiagnosis']) ){
            $template = str_replace('{diagnosis}', $row['Diagnosis'], $template);
        } else{
            $template = str_replace('{diagnosis}', $row['Diagnosis'] .' (បានប្តូរពី '. $row['OldDiagnosis'] .' ទៅ '. $row['Diagnosis'].')', $template);
        }

		$template = str_replace('{phone}', $row['Phone'], $template);

		return $template;
	}

	private function setReactiveCase($row)
	{
		$template = $this->getTemplate();
		$template = $template['ReactiveCase'];

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{entry_by}', $row['EntryBy'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);
		$template = str_replace('{phone}', $row['Phone'], $template);

		return $template;
	}

	private function setFociReminder($row)
	{
		$template = $this->getTemplate();
		$template = $template['FociReminder'];

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);

		return $template;
	}

	private function setReactiveReminder($row)
	{
		$template = $this->getTemplate();
		$template = $template['ReactiveReminder'];

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);

		return $template;
	}

	private function setHighRiskVillage($row)
	{
		$template = $this->getTemplate();
		$template = $template['HighRiskVillage'];

		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);

		return $template;
	}

	private function setStockOut($row)
	{
		$template = $this->getTemplate();
		$template = $template['StockOut'];

		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{item}', $row['Item'], $template);
		$template = str_replace('{phone}', $row['Phone'], $template);

		return $template;
	}

    function setNearExpiredStock($row)
    {
        $template = $this->getTemplate();
		$template = $template['NearExpiredStock'];

		$template = str_replace('{hc}', $row['Name_Facility_K'], $template);
		$template = str_replace('{od}', $row['Name_OD_K'], $template);
		$template = str_replace('{province}', $row['Name_Prov_K'], $template);
		$template = str_replace('{item}', $row['Description'], $template);
		$template = str_replace('{date}', $row['Date'], $template);

		return $template;
    }

	private function getTemplate($t)
	{
		$sql = "select * from tblNotificationTemplates";
		return $this->db->query($sql)->row_array()[$t];
	}
}