<?php

class MPatient extends CI_Model
{
	public function createCode($hfCode, $diagnosis, $code = '', $fingerprint = '')
	{
		if ($code != '') return $code;

        //if ($fingerprint == '') {
        //    if (!in_array($diagnosis, ['V', 'M'])) return '';
        //    if (!$this->isRadicalCure($hfCode)) return '';
        //}

        if( $diagnosis == 'N' && $diagnosis == 'S' ) return '';

		return $this->getNewCode();
	}

    public function getNewCode()
    {
        $sql = "select isnull(max(Code),0) + 1 as code from tblPatient";
		$newCode = $this->db->query($sql)->row('code');

        $this->db->insert('tblPatient', ['Code' => $newCode, 'PatientCode' => '']);

		$sql = "select code from ValueToCode('WA2009')";
		$patientCode = $this->db->query($sql)->row('code');

        $this->db->update('tblPatient', ['PatientCode' => $patientCode], ['Code' => $newCode]);

        return $patientCode;
    }

	private function isRadicalCure($hfCode)
	{
		if (strlen($hfCode) == 10) {
			$sql = "select a.IsReminder from tblHFCodes as a
				join tblCensusVillage as b on a.Code_Facility_T = b.HCCode
				where b.Code_Vill_T = '{$hfCode}'";
		} else {
			$sql = "select IsReminder from tblHFCodes where Code_Facility_T = '{$hfCode}'";
		}

		return $this->db->query($sql)->row('IsReminder') == 1;
	}

	public function createNotification($data)
	{
		if (in_array($data['Diagnosis'], ['F', 'N', 'A', 'K'])) return;
		//if (!$this->isRadicalCure($data['ID'])) return;
		if (empty($data['PatientCode'])) return;

		if (isset($data['Code_Vill_t'])) {
			$codePlace = $data['Code_Vill_t'];
			$prefix = 'HC_';
		} else {
			$codePlace = $data['ID'];
			$prefix = 'VMW_';
		}

		if(!isset($data['PrimaquineDate']) || empty($data['PrimaquineDate'])) return;

		$n = [];
		$n['CodePlace'] = $codePlace;
		$n['PatientCode'] = $data['PatientCode'];
		$n['CodeCase'] = $prefix . $data['Rec_ID'];
		$n['DateCase'] = $data['DateCase'];
		$n['Day3Date'] = addDay($data['PrimaquineDate'], 3);
		$n['Day3'] = 0;
		$n['Day7Date'] = addDay($data['PrimaquineDate'], 7);
		$n['Day7'] = 0;
		$n['Day14Date'] = addDay($data['PrimaquineDate'], 14);
		$n['Day14'] = 0;

		$this->db->delete('tblVMWNotification', ['CodeCase' => $n['CodeCase']]);
		$this->db->insert('tblVMWNotification', $n);
	}

	public function createHFNotification($data)
	{
		if (in_array($data['Diagnosis'], ['F', 'N', 'A', 'K'])) return;
		//if (!$this->isRadicalCure($data['ID'])) return;
		if (empty($data['PatientCode'])) return;
		if(!isset($data['PrimaquineDate']) || empty($data['PrimaquineDate'])) return;

		$n = [];
		$n['Code_Facility_T'] = $data['ID'];
		$n['PatientCode'] = $data['PatientCode'];
		$n['CodeCase'] = $data['Rec_ID'];
		$n['DateCase'] = $data['DateCase'];
		$n['Day3Date'] = addDay($data['PrimaquineDate'], 3);
		$n['Day3'] = 0;
		$n['Day7Date'] = addDay($data['PrimaquineDate'], 7);
		$n['Day7'] = 0;
		$n['Day14Date'] = addDay($data['PrimaquineDate'], 14);
		$n['Day14'] = 0;

		$this->db->delete('tblHFNotification', ['CodeCase' => $n['CodeCase']]);
		$this->db->insert('tblHFNotification', $n);
	}

	public function hasVMW($codeVill)
	{
		$sql = "select HaveVMW from tblCensusVillage where Code_Vill_T ='{$codeVill}'";
		$rs = $this->db->query($sql)->row('HaveVMW');
		return $rs;
	}

	public function getCase($id, $type = '')
	{
		if ($type == 'hc') return $this->getPatientHC($id);
		if ($type == 'vmw') return $this->getPatientVMW($id);
	}

	private function getPatientVMW($caseId)
	{
		$id = is_array($caseId) ? implode(', ', $caseId) : $caseId;
		$sql = "select Code_OD_T, c.Code_Prov_N, Name_Prov_K, Name_OD_K, Code_Facility_T, Name_Facility_K,
				Name_Vill_K, a.Rec_ID, NameK, PatientCode,
				case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' when Diagnosis = 'M' then 'Mix'
				when Diagnosis = 'A' then 'Pm' when Diagnosis = 'O' then 'Po' when Diagnosis = 'K' then 'Pk' end as Diagnosis,
				Age, Sex, isnull(PatientPhone, 'N/A') as PatientPhone, N'VMWភូមិ' + Name_Vill_K as EntryBy, isnull(e.Phone, 'N/A') as Phone, L1
				from tblVMWActivityCases as a
				join tblCensusVillage as b on a.ID = b.Code_Vill_T
				join tblHFCodes as c on b.HCCode = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Vill_T from tblVMWDevice group by Code_Vill_T
				) as e on b.Code_Vill_T = e.Code_Vill_T
				where a.Rec_ID in ({$id})";

		$q = $this->db->query($sql);
		return is_array($caseId) ? $q->result_array() : $q->row_array();
	}

	private function getPatientHC($caseId)
	{
		$sql = "select c.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K, a.Rec_ID,
				NameK, Age, Sex, isnull(PatientPhone, 'N/A') as PatientPhone,
				case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' when Diagnosis = 'M' then 'Mix'
				when Diagnosis = 'A' then 'Pm' when Diagnosis = 'O' then 'Po' when Diagnosis = 'K' then 'Pk' end as Diagnosis,
				'HC' + Name_Facility_K as EntryBy, isnull(Phone, 'N/A') as Phone, L1
				from tblHFActivityCases as a
				join tblCensusVillage as b on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_T
				join tblHFCodes as c on a.ID = c.Code_Facility_T
				join tblProvince as d on c.Code_Prov_N = d.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
				) as e on c.Code_Facility_T = e.Code_Facility_T
				where a.Rec_ID = '{$caseId}'";

		$q = $this->db->query($sql);
		return $q->row_array();
	}

	private function getPatients($caseIds)
	{
		$caseIds = implode(', ', $caseIds);
		$sql = "select Code_OD_T, d.Code_Prov_N, Name_Prov_K, Name_OD_K, Code_Facility_T, Name_Facility_K,
				Name_Vill_K, NameK, PatientCode,
				case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' when Diagnosis = 'M' then 'Mix'
				when Diagnosis = 'A' then 'Pm' when Diagnosis = 'O' then 'Po' when Diagnosis = 'K' then 'Pk' end as Diagnosis,
				Age, Sex, isnull(PatientPhone, 'N/A') as PatientPhone, N'VMWភូមិ' + Name_Vill_K as EntryBy, Token, Imei, L1
				from tblVMWActivityCases as a
				join tblCensusVillage as b on b.Code_Vill_T = a.ID
				join tblToken as c on c.CodePlace = b.HCCode
				join tblHFCodes as d on b.HCCode = d.Code_Facility_T
				join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				where a.Rec_ID in ({$caseIds})";

		return $this->db->query($sql)->result_array();
	}

	public function getFociReminderHC()
	{
		$sql = "select c.Code_Vill_T, d.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
				a.NameK, a.Age, a.Diagnosis, a.Sex, isnull(b.Passive_Case_Id, 0) HasData, 'hc' as caseType
				from tblHFActivityCases as a
				left join (select distinct Passive_Case_Id from tblFociInvestigation2) as b on CONCAT(a.Rec_ID, '_HC') = b.Passive_Case_Id
				join tblCensusVillage as c on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = c.Code_Vill_T
				join tblHFCodes as d on a.ID = d.Code_Facility_T
				join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
				) as f on d.Code_Facility_T = f.Code_Facility_T
				where a.Diagnosis = 'F' and L1 = 1 and DATEDIFF(day, a.DateCase, GetDate()) = 5";

		$rs = $this->db->query($sql)->result_array();
		return notInArray($rs, [1], 'HasData');
	}

	public function getFociReminderVMW()
	{
		$sql = "select c.Code_Vill_T, d.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
				a.NameK, a.Age, a.Diagnosis, a.Sex, isnull(b.Passive_Case_Id, 0) HasData, 'vmw' as caseType
				from tblVMWActivityCases as a
				left join (select distinct Passive_Case_Id from tblFociInvestigation2) as b on CONCAT(a.Rec_ID, '_VMW') = b.Passive_Case_Id
				join tblCensusVillage as c on a.ID = c.Code_Vill_T
				join tblHFCodes as d on c.HCCode = d.Code_Facility_T
				join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
				) as f on d.Code_Facility_T = f.Code_Facility_T
				where a.Diagnosis = 'F' and L1 = 1 and DATEDIFF(day, a.DateCase, GetDate()) = 5";

		$rs = $this->db->query($sql)->result_array();
		return notInArray($rs, [1], 'HasData');
	}

	public function getReactiveReminderHC()
	{
		$sql = "select c.Code_Vill_T, d.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
				a.NameK, a.Age, a.Diagnosis, a.Sex, isnull(b.Passive_Case_Id, 0) HasData, 'hc' as caseType
				from tblHFActivityCases as a
				left join (select distinct Passive_Case_Id from tblReactive2) as b on CONCAT(a.Rec_ID, '_HC') = b.Passive_Case_Id
				join tblCensusVillage as c on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = c.Code_Vill_T
				join tblHFCodes as d on a.ID = d.Code_Facility_T
				join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
				) as f on d.Code_Facility_T = f.Code_Facility_T
				where ((a.Diagnosis = 'F' and L1 = 0) or (a.Diagnosis = 'V' and L1 = 1)) and DATEDIFF(day, a.DateCase, GetDate()) = 3";

		$rs = $this->db->query($sql)->result_array();
		return notInArray($rs, [1], 'HasData');
	}

	public function getReactiveReminderVMW()
	{
		$sql = "select c.Code_Vill_T, d.Code_Facility_T, Code_OD_T, Code_Prov_N, Name_Vill_K, Name_Facility_K, Name_OD_K, Name_Prov_K,
				a.NameK, a.Age, a.Diagnosis, a.Sex, isnull(b.Passive_Case_Id, 0) HasData, 'vmw' as caseType
				from tblVMWActivityCases as a
				left join (select distinct Passive_Case_Id from tblReactive2) as b on CONCAT(a.Rec_ID, '_VMW') = b.Passive_Case_Id
				join tblCensusVillage as c on a.ID = c.Code_Vill_T
				join tblHFCodes as d on c.HCCode = d.Code_Facility_T
				join tblProvince as e on d.Code_Prov_N = e.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
				) as f on d.Code_Facility_T = f.Code_Facility_T
				where ((a.Diagnosis = 'F' and L1 = 0) or (a.Diagnosis = 'V' and L1 = 1)) and DATEDIFF(day, a.DateCase, GetDate()) = 3";

		$rs = $this->db->query($sql)->result_array();
		return notInArray($rs, [1], 'HasData');
	}

	//TODO remove this function
	public function getPatientList()
	{
		$sql = "WITH T as (
					select a.Rec_ID, ID, NameK, PatientCode, Age, Sex, ISNULL(PatientPhone, 'N/A') as PatientPhone, iif(ISNUMERIC(Code_Vill_t) = 0, cast(Code_Vill_t as nvarchar), 'N/A') as Name_Vill_K,
					L1, LC, IMP, Diagnosis, Year, IsNotified, 'HC' as EntryBy, 'tblHFActivityCases' as tblName, OldDiagnosis
					from tblHFActivityCases as a
					where ISNUMERIC(a.Code_Vill_t) = 0 or len(a.Code_Vill_t) < 10

					union all

					select a.Rec_ID, ID, NameK, PatientCode, Age, Sex, ISNULL(PatientPhone, 'N/A') as PatientPhone, ISNULL(Name_Vill_K collate Thai_100_BIN, 'N/A') as Name_Vill_K,
					L1, LC, IMP, Diagnosis, Year, IsNotified, 'HC' as EntryBy, 'tblHFActivityCases' as tblName, OldDiagnosis
					from tblHFActivityCases as a
					left join tblCensusVillage as b on a.Code_Vill_t collate SQL_Latin1_General_CP1_CI_AS = b.Code_Vill_T
					where ISNUMERIC(a.Code_Vill_t) = 1 and len(a.Code_Vill_t) = 10

					union all

					select a.Rec_ID, HCCode, NameK, PatientCode, Age, Sex, ISNULL(PatientPhone, 'N/A') as PatientPhone, Name_Vill_K,
					L1, LC, IMP, Diagnosis, Year, IsNotified, 'VMW' as EntryBy, 'tblVMWActivityCases' as tblName, OldDiagnosis
					from tblVMWActivityCases as a
					join tblCensusVillage as b on a.ID = b.Code_Vill_T
				)

				select a.Rec_ID, Code_OD_T, b.Code_Prov_N, Name_Prov_K, Name_OD_K, b.Code_Facility_T, Name_Facility_K,
					Name_Vill_K, NameK, PatientCode,
					case when Diagnosis = 'V' then 'Pv' when Diagnosis = 'F' then 'Pf' when Diagnosis = 'M' then 'Mix'
					when Diagnosis = 'A' then 'Pm' when Diagnosis = 'O' then 'Po' when Diagnosis = 'K' then 'Pk' end as Diagnosis,
					Diagnosis as DiagnosisAbre,
					Age, Sex, isnull(PatientPhone, 'N/A') as PatientPhone, iif(EntryBy = 'HC', Concat('HC' collate Thai_100_BIN, Name_Facility_K collate Thai_100_BIN), Concat(N'VMWភូមិ' collate Thai_100_BIN, Name_Vill_K collate Thai_100_BIN)) as EntryBy, isnull(e.Phone, 'N/A') as Phone, L1, LC, IMP, tblName, OldDiagnosis
				from T as a
				join tblHFCodes as b on a.ID = b.Code_Facility_T
				join tblProvince as d on b.Code_Prov_N = d.Code_Prov_T
				join (
					select max(Phone) as Phone, Code_Facility_T from tblHFDevice group by Code_Facility_T
				) as e on b.Code_Facility_T = e.Code_Facility_T
				where a.Diagnosis in ('F', 'M', 'V', 'A', 'O', 'K') and a.IsNotified = 0 and b.IsTarget = 1";

		$q = $this->db->query($sql);
        return $q->result_array();
	}

    public function searchPatient(array $patient)
    {
        ini_set('memory_limit', '-1');
        $name = $patient['name'];
        $code = $patient['code'];
        $phone =  $patient['phone'];
        $age = $patient['age'];
        $sex = $patient['sex'];
        $vill = $patient['vill'];

        $key1 = implode("%",$patient);
        $key2 = $name . '%' . $code;
        $key3 = $name . '%' . $code . '%' . $sex;
        $key4 = $name . '%' . $code . '%' . $sex . '%' . $age;
        $key5 = $name . '%' . $code . '%' . $sex . '%' . $age . '%'. $phone;
        $key6 = $name . '%' . $code . '%' . $sex . '%' . $age . '%'. $phone . '%' . $vill;

        if (!$code && !$name && !$phone) {
            $error = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Must provide patient code or patient name or patient phone'
            ];

            return $error;
        }

        $sql = "WITH cases as (
                select  PatientCode, NameK, Age, Sex,G6PDdL, G6PDHb, PatientPhone, Code_Vill_t, DateCase, concat('HC_',Rec_ID) as Case_ID,
                concat(NameK, ' ', convert(nvarchar ,PatientCode) collate Khmer_100_BIN,' ',convert(nvarchar ,Sex) collate Khmer_100_BIN,' ', convert(nvarchar ,Age) collate Khmer_100_BIN, ' ', convert(nvarchar ,PatientPhone) collate Khmer_100_BIN, ' ', convert(nvarchar ,Code_Vill_t) collate Khmer_100_BIN) as Criteria
                from tblHFActivityCases
                where Positive = 'P'
                and Year >=2020

                union all

                select  PatientCode, NameK, Age, Sex,G6PDdL, G6PDHb, PatientPhone, ID, DateCase, concat('VMW_',Rec_ID) as Case_ID,
                concat(NameK, ' ', convert(nvarchar ,PatientCode) collate Khmer_100_BIN,' ',convert(nvarchar ,Sex) collate Khmer_100_BIN,' ', convert(nvarchar ,Age) collate Khmer_100_BIN, ' ', convert(nvarchar ,PatientPhone) collate Khmer_100_BIN, ' ', convert(nvarchar ,ID) collate Khmer_100_BIN) as Criteria
                from tblVMWActivityCases
                where Positive = 'P'
                and Year >=2020
                )

                select a.*, Name_Vill_K, Name_Comm_K, Name_Dist_K,Name_Prov_K
                from cases as a
                join tblCensusVillage as b on a.Code_Vill_t = b.Code_Vill_T
                join tblCommune as c on b.Code_Comm_T = c.Code_Comm_T
                join tblDistrict as d on b.Code_Dist_T = d.Code_Dist_T
                join tblProvince as e on b.Code_Prov_T = e.Code_Prov_T
                where
                    Criteria like N'%$key1%'
                or Criteria like N'%$key2%'
                or Criteria like N'%$key3%'
                or Criteria like N'%$key4%'
                or Criteria like N'%$key5%'
                or Criteria like N'%$key6%'
                ";

        $data = $this->db->query( $sql )->result_array();

        array_walk($data, function (&$a, $k) {
			unset($a['Criteria']);
		});

        return $data;
    }

    public function getPatient($rec_id, $type)
    {
        $tbl = $type == 'HC' ? 'tblHFActivityCases' : 'tblVMWActivityCases';
        $rs = $this->db->get_where($tbl, ['Rec_ID'=>$rec_id])->row_array();
        return $rs;
    }

    public function logPfMix($row, $caseType)
    {
        $data = [
            'Year' => $row['Year'],
            'Month' => $row['Month'],
            'NameK' => $row['NameK'],
            'Age' => $row['Age'],
            'Sex' => $row['Sex'],
            'CaseType' => $caseType,
            'Place' => $row['ID'],
            'Specie' => $row['Diagnosis'],
            'Description' => json_encode($row),
            'InitTime' => sqlNow()
       ];

       $this->db->insert('tblPreConfirmCase', $data);
       $recId = $this->db->insert_id();
       return $recId;
    }

	public function search($caseId, $patientCode)
    {
        $sql = "WITH t as
				(
				select PatientCode, Rec_ID, CONCAT('VMW_', Rec_ID) as Case_ID from tblVMWActivityCases

				union all

				select PatientCode, Rec_ID, CONCAT('HC_', Rec_ID) as Case_ID from tblHFActivityCases
				)

				select * from t
				where PatientCode = '{$patientCode}' and Rec_ID = '{$caseId}'";

		return $this->db->query( $sql )->row_array();
    }
}