<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient extends MY_Controller
{
	public function index()
	{
        if (!isset($_SESSION['permiss']['Patient'])) redirect('Home');

		$data['title'] = 'Patient';
		$data['main'] = 'patient_view';
		$this->load->view('layout', $data);
	}

    public function getData()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $sql = "with t as (
                    select Rec_ID, PatientCode, NameK, PatientPhone, Age, Sex, Code_Vill_t, DateCase, Year, Month, 'tblHFActivityCases' as tbl, 'HC' as CaseType
                    from tblHFActivityCases where Positive = 'P' and Year > 2021
                    union all
                    select Rec_ID, PatientCode,  NameK, PatientPhone, Age, Sex, ID, DateCase, Year, Month, 'tblVMWActivityCases' as tbl, 'VMW' as CaseType
                    from tblVMWActivityCases where Positive = 'P' and Year > 2021
                )

                select a.*, e.Code_Prov_T, Code_OD_T, Code_Facility_T, iif(f.Status is null, '', Status) as Status

                from t as a
                join tblCensusVillage as c on c.Code_Vill_T = a.Code_Vill_t
                join tblHFCodes as d on c.HCCode = d.Code_Facility_T
                join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
                left join (
                    select Distinct PatientCode, Status from tblPatientCodeStatus
                )
                as f on a.PatientCode = f.PatientCode
                where d.IsTarget =1
                order by DateCase desc, Year desc, Month desc";

        $rs = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }

    public function updateCode() {
        $p = $this->input->post('submit');

        $data = [
            'PatientCode' => $p['PatientCode'],
            'NameK' => $p['NameK']
        ];

        $this->db->update($p['tbl'], $data, ['Rec_ID' => $p['Rec_ID']]);

        if( isset($p['State']) ) {
            $this->db->delete('tblPatientCodeStatus', ['PatientCode' => $p['PatientCode']]);

            $state = [
                'CaseID' => $p['Rec_ID'],
                'CaseType' => $p['CaseType'],
                'PatientCode' => $p['PatientCode'],
                'Status' => $p['Status']
            ];

            $this->db->insert('tblPatientCodeStatus', $state);
        }

        $this->output->set_output(json_encode(1));
    }

    public function getDuplicatedPatientCode(){
        $sql = "with t as (
                    select Rec_ID, PatientCode, NameK, 'tblHFActivityCases' as tbl, 'HC' as CaseType
                    from tblHFActivityCases where Positive = 'P' and Year > 2021
                    union all
                    select Rec_ID, PatientCode,  NameK, 'tblVMWActivityCases' as tbl, 'VMW' as CaseType
                    from tblVMWActivityCases where Positive = 'P' and Year > 2021
                )

                select * from t
                inner join (
                 select  PatientCode as Code, NameK as Name from t group by PatientCode, NameK having count(*) >1
                ) as b on t.PatientCode= b.Code and t.NameK <> b.Name
                order by t.PatientCode";

        $rs = $this->db->query($sql)->result();

        $this->output->set_output(json_encode($rs));
    }
}