<?php
require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MessageSender;

defined('BASEPATH') or exit('No direct script access allowed');

class VMWFollowup_model extends CI_Model
{
	public function notify($day)
	{
		$msg = new SingleMessage();
		$sender = new MessageSender( $msg );

		$followups = $this->getFollowup($day);
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

		$sql = "with t as
				(
					select Rec_ID, CONCAT('VMW_', Rec_ID) as CodeCase, NameK, Sex, Age, PatientCode, Diagnosis, PatientPhone, ID as Code_Vill_T, G6PDHb,G6PDdL, DateCase, PrimaquineDate
					from tblVMWActivityCases
					where Diagnosis in ('V', 'M', 'O') and (Primaquine15 > 0 or Primaquine75 > 0)

					union all

					select Rec_ID, CONCAT('HC_', Rec_ID) as CodeCase, NameK, Sex, Age, PatientCode, Diagnosis, PatientPhone,  a.Code_Vill_T, G6PDHb,G6PDdL, DateCase, PrimaquineDate
					from tblHFActivityCases as a
					join tblCensusvillage as b on a.Code_Vill_t = b.Code_Vill_T
					where Diagnosis in ('V', 'M', 'O') and (Primaquine15 > 0 or Primaquine75 > 0) and HaveVMW = 1
				)

				select a.Rec_ID, Token, NameK, Sex, Age, a.PatientCode, Diagnosis, PatientPhone,
						Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K ,
						DATEADD({$dayType}, {$dayNumber}, PrimaquineDate) as DayDate, '{$day}' as Day
				,iif( (Sex='M' and G6PDdL >= 4.1 and G6PDHb >=7.1) or (Sex='F' and G6PDdL >= 6.1 and G6PDHb >=7.1),1,0) as IsG6PDNormal
				from t as a
				join tblToken as c on c.CodePlace = a.Code_Vill_T
				join tblCensusVillage as d on d.Code_Vill_T = a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS
				join tblHFCodes as e on e.Code_Facility_T = d.HCCode
				join tblProvince as f on f.Code_Prov_T = e.Code_Prov_N
				where DATEDIFF(day, getdate(), DATEADD({$dayType}, {$dayNumber}, PrimaquineDate)) = {$dayBefore}";

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
		$template = str_replace('{follow_up_date}',date("d-m-Y", strtotime($row['DayDate'])), $template);
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