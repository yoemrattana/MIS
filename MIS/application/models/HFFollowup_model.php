<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MessageSender;

class HFFollowup_model extends CI_Model
{
	public function notify($day)
	{
		$followups = $this->getFollowup($day);
		$msg = new SingleMessage();
		$sender = new MessageSender( $msg );

		foreach( $followups as $followup ) {

			if($followup['IsG6PDNormal'] == 1 && in_array($day, ['WEEK-2','WEEK-3', 'WEEK-4' ,'WEEK-5','WEEK-6', 'WEEK-7', 'WEEK-8'])) continue;

			$title = 'តាមដានអ្នកជម្ងឺ';
			$token = $followup['Token'];
			$body = $this->setTemplate($followup);

            $msg->setMessage( $token, $title, $body );
            $sender->send();

			sleep(0.2);
		}
	}

	public function getFollowup($day)
	{
		$dayBefore = $this->getDayBefore();

		[$dayType, $dayNumber] = explode('-', $day);

		$sql = "select Token, NameK, Sex, Age, b.PatientCode, Diagnosis, PatientPhone,
				Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
				DATEADD({$dayType}, {$dayNumber}, PrimaquineDate) as DayDate, '{$day}' as Day
				,iif( (Sex='M' and G6PDdL >= 4.1 and G6PDHb >=7.1) or (Sex='F' and G6PDdL >= 6.1 and G6PDHb >=7.1),1,0) as IsG6PDNormal
				from tblHFActivityCases as b
				join tblToken as c on c.CodePlace = b.ID
				join tblCensusVillage as d on d.Code_Vill_T = b.Code_Vill_t
				join tblHFCodes as e on e.Code_Facility_T = d.HCCode
				join tblProvince as f on f.Code_Prov_T = e.Code_Prov_N
				where (Primaquine15 > 0 or Primaquine75 > 0) and DATEDIFF(day, getdate(), DATEADD({$dayType}, {$dayNumber}, PrimaquineDate)) = {$dayBefore}";

		return $this->db->query($sql)->result_array();
	}

	private function getDayBefore()
	{
		$dayBefore = $this->db->get_where('tblSetting', ['Name' => 'AlertDayBefore'])->row('Value');
		return (int) $dayBefore;
	}

	public function setTemplate($row)
	{
		$sql = "select * from tblSetting where Name = 'VMWTemplate'";
		$template = $this->db->query($sql)->row('Value');

		$template = str_replace('{code}', $row['PatientCode'], $template);
		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{village}', $row['Name_Vill_K'], $template);
		$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
		$template = str_replace('{day}', $this->selectDay($row['Day']), $template);
		$template = str_replace('{follow_up_date}', date("d-m-Y", strtotime($row['DayDate'])), $template);
		//$template = str_replace('{vmw_phone}', $row['VMWPhone'], $template);
		$template = str_replace('{diagnosis}', $row['Diagnosis'], $template);

		return $template;
	}

	private function selectDay($day)
	{
		switch($day) {
			case 'DAY-3':
				$day = 'ថ្ងៃទី៣';
				break;
			case 'DAY-7':
				$day = 'ថ្ងៃទី៧';
				break;
			case 'WEEK-2':
				$day = 'សប្តាហ៍ទី២';
				break;
			case 'WEEK-3':
				$day = 'សប្តាហ៍ទី៣';
				break;
			case 'WEEK-4':
				$day = 'សប្តាហ៍ទី៤';
				break;
			case 'WEEK-5':
				$day = 'សប្តាហ៍ទី៥';
				break;
			case 'WEEK-6':
				$day = 'សប្តាហ៍ទី៦';
				break;
            case 'WEEK-7':
				$day = 'សប្តាហ៍ទី៧';
				break;
            case 'WEEK-8':
				$day = 'សប្តាហ៍ទី៨';
				break;
			default:
				$day = 0;
		}
		return $day;
	}
}