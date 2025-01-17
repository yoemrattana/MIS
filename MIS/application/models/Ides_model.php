<?php
require_once FCPATH.'/vendor/autoload.php';
use Message\SingleMessage;
use Message\MessageSender;

defined('BASEPATH') or exit('No direct script access allowed');

class Ides_model extends CI_Model
{
    public function notifyIdesHF($day)
    {
        $patients = $this->getPatientsHF( $day );
        $msg = new SingleMessage();
		$sender = new MessageSender( $msg );

        if ( empty($patients) ) return;
        foreach( $patients as $patient ) {
            $title = 'តាមដានអ្នកជម្ងឺ iDes';
            $token = $patient['Token'];
            $body = $this->setTemplate( $patient );

            $msg->setMessage( $token, $title, $body );
            $sender->send();

            $this->load->model('Log_model');
            $this->Log_model->logIdes($patient);
			sleep(0.2);
        }
    }

    public function notifyIdesVMW($day)
    {
        $patients = $this->getPatientsVMW( $day );
        $msg = new SingleMessage();
		$sender = new MessageSender( $msg );

        if ( empty($patients) ) return;
        foreach( $patients as $patient ) {
            $title = 'តាមដានអ្នកជម្ងឺ iDes';
            $token = $patient['Token'];
            $body = $this->setTemplate( $patient );

            $msg->setMessage( $token, $title, $body );
            $sender->send();

            $this->load->model('Log_model');
            $this->Log_model->logIdes($patient);
			sleep(0.2);
        }
    }

    public function getPatientsHF($day)
    {
        $sql = "select
	            NameK
                ,PatientPhone
	            ,Age, Sex
	            ,dbo.ToSpecies(Diagnosis) as Species
	            ,convert(date,DATEADD(day,$day,DateCase)) as Date
                ,$day as Day
	            ,Name_Facility_K
	            ,Token
                ,a.ID
            from tblHFActivityCases as a
            join tblToken as b on a.ID = b.CodePlace
            join tblHFCodes as c on a.ID = c.Code_Facility_T
            left join tbliDesDetail as d on d.Case_ID = a.Rec_ID and Case_Type = 'HC' and Days = CONCAT('D', $day)
            where Positive = 'P'
            and DATEDIFF(day, GETDATE(), convert(date,DATEADD(day, $day, DateCase))) between -3 and 3 and Case_ID is null";

        return $this->db->query($sql)->result_array();
    }

    public function getPatientsVMW($day)
    {
        $sql = "select
	            NameK
                ,PatientPhone
	            ,Age, Sex
	            ,dbo.ToSpecies(Diagnosis) as Species
	            ,convert(date,DATEADD(day,$day,DateCase)) as Date
                ,$day as Day
	            ,Token
                ,a.ID
            from tblVMWActivityCases as a
            join tblToken as b on a.ID = b.CodePlace
            left join tbliDesDetail as d on d.Case_ID = a.Rec_ID and Case_Type = 'VMW' and Days = CONCAT('D', $day)
            where Positive = 'P'
            and DATEDIFF(day, GETDATE(), convert(date,DATEADD(day, $day, DateCase))) between -3 and 3 and Case_ID is null";

        return $this->db->query($sql)->result_array();
    }

    public function setTemplate($row)
	{
		$sql = "select * from tblSetting where Name = 'Ides'";
		$template = $this->db->query($sql)->row('Value');

		$template = str_replace('{name}', $row['NameK'], $template);
		$template = str_replace('{sex}', $row['Sex'] == 'M' ? 'ប្រុស' : 'ស្រី', $template);
		$template = str_replace('{age}', $row['Age'], $template);
		$template = str_replace('{patient_phone}', $row['PatientPhone'], $template);
		$template = str_replace('{day}', $row['Day'], $template);
		$template = str_replace('{date}',date("d-m-Y", strtotime($row['Date'])), $template);

		return $template;
	}
}