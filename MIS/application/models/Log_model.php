<?php

class Log_model extends CI_Model
{
    public function __construct()
	{
		parent::__construct();
        $this->load->model('Ides_model');
	}

	public function logCase($data)
	{
		if(empty($data['Imei'])) return;

		$this->db->insert("tblNotificationLog", $data);
	}

	public function logStock($data)
	{
		if(empty($data['Imei'])) return;

		$this->db->insert("tblNotificationLog", $data);
	}

    public function logIdes($patient)
    {
        $body = $this->Ides_model->setTemplate($patient);
        $data = [
            'Message'=>$body,
            'Place_Code' => $patient['ID'],
            'Type' => strlen($patient['ID']) == 10 ? 'VMW' : 'HC',
            'InitTime' => sqlNow()
        ];

		$this->db->insert("tbliDesNotification", $data);
    }

	public function deleteCase($table, $recID)
	{
        $row = $this->getData($table, ['Rec_ID'=> $recID]);
        if(empty($row)) return ;
        $row['Module'] = 'case';
        $row['Place'] = $row['ID'];

        $data = $this->constructData($row);

		$this->db->insert('tblLogDelete', $data);
	}

    public function deleteLastmileHouse($recID)
	{
		$row = $this->getData('tblLastmileHouseHold', ['Rec_ID' => $recID]);

        $row['Module'] = 'lastmile';
        $row['Place'] = $row['Code_Vill_T'];
        $data = $this->constructData($row);

		$this->db->insert('tblLogDelete', $data);
	}

    public function deleteTDA($type, $houseHoldId)
    {
        $tdas = $this->getTDA($type, $houseHoldId);

        $data = $this->constructData($tdas);

		$this->db->insert('tblLogDelete', $data);
    }

    private function getTDA($type, $houseHoldId)
    {
        $tdas = $this->getData('tblLastmileTDA', ['Type' => $type, 'HouseHoldID'=>$houseHoldId], false);
        $house = $this->getData('tblLastmileHouseHold', ['Rec_ID'=> $houseHoldId]);

        array_walk($tdas, function (&$a, $k) use ($house) {
			$a['HouseNumber'] = $house['HouseNumber'];
            $a['HouseHolder'] = $house['HouseHolder'];
            $a['Place'] = $house['Code_Vill_T'];
            $a['Module']= 'tda';
		});

        return $tdas;
    }

    public function deleteIPT($date, $houseHoldId)
    {
        $ipts = $this->getIPT($date, $houseHoldId);

        $data = $this->constructData($ipts);

		$this->db->insert('tblLogDelete', $data);
    }

    private function getIPT($date, $houseHoldId)
    {
        $ipts = $this->getData('tblLastmileIPT', ['IPTDate' => $date, 'HouseHoldID'=>$houseHoldId], false);
        $house = $this->getData('tblLastmileHouseHold', ['Rec_ID'=> $houseHoldId]);

        array_walk($ipts, function (&$a, $k) use ($house) {
			$a['HouseNumber'] = $house['HouseNumber'];
            $a['HouseHolder'] = $house['HouseHolder'];
            $a['Place'] = $house['Code_Vill_T'];
            $a['Module']= 'ipt';
		});

        return $ipts;
    }

    public function deleteAFS($date, $houseHoldId)
    {
        $afs = $this->getAFS($date, $houseHoldId);

        $data = $this->constructData($afs);

        $this->db->insert('tblLogDelete', $data);
    }

    private function getAFS($date, $houseHoldId)
    {
        $afs = $this->getData('tblLastmileAFS', ['AFSDate'=>$date, 'HouseHoldID'=>$houseHoldId], false);
        $house = $this->getData('tblLastmileHouseHold', ['Rec_ID'=> $houseHoldId]);

        array_walk($afs, function (&$a, $k) use ($house) {
			$a['HouseNumber'] = $house['HouseNumber'];
            $a['HouseHolder'] = $house['HouseHolder'];
            $a['Place'] = $house['Code_Vill_T'];
            $a['Module']= 'afs';
		});

        return $afs;
    }

    public function deleteEntomo($submit)
    {
        $row = $this->getEntomo($submit);
        $data = $this->constructData($row);
        $this->db->insert('tblLogDelete', $data);
    }

    private function getEntomo($submit)
    {
        $row = $this->getData($submit['table'], $submit['where']);

        $row['Module'] = $submit['table'] == 'tblEntomologyMosquito' ? 'entomo-mosquito' : 'entomo-insecticide';
        $date = $submit['table'] == 'tblEntomologyMosquito' ? 'CollectionDate' : 'InsecticideDate';
        $row['Month'] = date("m",strtotime($row[$date]));
        $row['Year'] = date("Y",strtotime($row[$date]));
        $row['Place'] = $row['Code_Vill_T'];

        return $row;
    }

    public function deleteVMWQA($submit)
    {
        $row = $this->getVMWQA($submit);
        $data = $this->constructData($row);

        $this->db->insert('tblLogDelete', $data);
    }

    private function getVMWQA($submit)
    {
        $row = $this->getData($submit['table'], $submit['where']);

        $row['Module'] = 'vmwqa';
        $row['Month'] = date("m",strtotime($row['VisitDate']));
        $row['Year'] = date("Y",strtotime($row['VisitDate']));
        $row['Place'] = $row['Code_Vill_T'];

        return $row;
    }

	public function deleteStock($row) {
        $data = $this->constructData($row);

		$this->db->insert('tblLogDelete', $data);
	}

    public function deleteFollowup($table, $recID)
    {
        $followUp = $this->getFollowup($table, $recID);

		$data = $this->constructData($followUp);

		$this->db->insert('tblLogDelete', $data);
    }

    private function getFollowup($table, $recID)
    {
        $followUp = $this->getData($table, ['Rec_ID' => $recID]);

        $caseTbl = $table == 'tblHFFollowup' ? 'tblHFActivityCases' : 'tblVMWActivityCases';
        $caseId = $this->getCaseId($followUp['Case_ID']);
        $case = $this->getData($caseTbl, ['Rec_ID'=> $caseId]);

        $followUp['NameK'] = $case['NameK'];
        $followUp['Age'] = $case['Age'];
        $followUp['Sex'] = $case['Sex'];
        $followUp['Diagnosis'] = $case['Diagnosis'];
        $followUp['Month'] = $case['Month'];
        $followUp['Year'] = $case['Year'];
        $followUp['Place'] = $case['ID'];
        $followUp['Module'] = $table == 'tblHFFollowup' ? 'hf-radical-cure' : 'vmw-radical-cure';
        return $followUp;
    }

    private function getCaseId($str)
    {
        $idSplit = explode('_', $str);
        $caseId = count($idSplit) > 1 ? $idSplit[1] : $str;
        return $caseId;
    }

    private function getData($tbl, $where, $onlyOne = true)
    {
        $q = $this->db->get_where($tbl, $where);
        return $onlyOne ? $q->row_array() : $q->result_array();
    }

    private function constructData($data)
    {
        $row = $this->isMultiArray($data) ? $data[0] : $data;

        return [
			'Month'         => $row['Month'],
			'Year'          => $row['Year'],
			'Place'         => $row['Place'],
			'Module'        => $row['Module'],
			'InitTime'      => sqlNow(),
			'InitUser'      => isset($_SESSION['username']) ? $_SESSION['username'] : 'HC',
			'Description'   => json_encode($data),
			'IsMobile'      => isset($_SESSION['username']) ? 0 : 1,
		];
    }

    private function isMultiArray(array $array) {
        return count($array) !== count($array, COUNT_RECURSIVE);
    }
}