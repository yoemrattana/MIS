<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class His extends MY_Controller
{
	private $month;
	private $year;

	public function index()
	{
		if ($_SESSION['role'] != 'AU') redirect('Home');

		$data['title'] = "HIS";
		$data['main'] = 'his_view';

		$this->load->view('layout', $data);
	}

	public function upload()
	{
		$submit = json_decode($this->input->post('submit'));

		$files = $submit->files;
		sort($files);
		$ext = 'xls';

		foreach( $files as $file ) {
			$tempName = TEMPPATH . uniqid() . $ext;

			write_file($tempName, base64_decode($file->b64));

			$this->load->library('PHPExcel');
			try {
				$excel = PHPExcel_IOFactory::load($tempName);
			}
			catch (Exception $e) {
				die ('ERROR: ' . $e->getMessage());
			}

			$msg = '';

			if( $file->fileName == '1-treat.xls' ) $msg = $this->treatedCase($excel);
			if( $file->fileName == '2-dipstick.xls' ) $msg = $this->confirmDipstick($excel);
			if( $file->fileName == '3-slide.xls' ) $msg = $this->confirmSlide($excel);
			if( $file->fileName == '4-vmw.xls' ) $msg = $this->vmw($excel);
		}

		if (empty($msg)) {
		    $this->output->set_output(json_encode(['status' => 'successful', 'msg' => $msg]));
		    return;
		}

		$this->output->set_output(json_encode(['status' => 'error', 'msg' => $msg]));
	}

	private function treatedCase($excel)
	{
		$sheets = [
			'SimpleMalaria-OPD',
			'SevereMalaria-OPD',
			'SimpleMalaria-IPD',
			'SevereMalaria-IPD'
		];

		$rsTreatedCase = [];
		foreach( $sheets as $sheet ) {
			$treatedCases = $this->getTreatedCase($excel, $sheet);

			if( !is_array($treatedCases) ) return $treatedCases;
			$rsTreatedCase[$sheet] = $treatedCases;
		}

		$simple1 = $rsTreatedCase['SimpleMalaria-OPD'];
		$simple2 = $rsTreatedCase['SimpleMalaria-IPD'];

		$severe1 = $rsTreatedCase['SevereMalaria-OPD'];
		$severe2 = $rsTreatedCase['SevereMalaria-IPD'];

		$i = 0;
		$simpleCases = [];
		foreach($simple1 as $key => $val){
			$row = [];
			$j = 0;
			foreach(array_keys($val) as $k) {
				if( $j == 0 ) {
					$row[$k] = $simple1[$i][$k];
				}
				else {
					if ( in_array( $k, ['OPD_U_5', 'OPD_Over_5', 'OPD_F', 'OPD_Death', 'OPD_Severe'] ) ) $row[$k] = $simple1[$i][$k] + $severe1[$i][$k]; //OPD
					else $row[$k] =  $simple1[$i][$k] + $simple2[$i][$k];
				}
				$j++;
			}
			$simpleCases[] = $row;
			$i++;
		}

		$severeCases = [];
		$i=0;
		foreach($severe2 as $key => $val){
			$row = [];
			$j = 0;
			foreach(array_keys($val) as $k) {
				if( $j == 0 ) {
					$row[$k] = $severe1[$i][$k];
				}
				else {
					if ( in_array( $k, ['IPD_U_5', 'IPD_Over_5', 'IPD_F', 'IPD_Death', 'IPD_Severe'] ) ) $row[$k] = $severe2[$i][$k] + $simple2[$i][$k]; //IPD
					else $row[$k] =  $severe1[$i][$k] + $severe2[$i][$k];
				}
				$j++;
			}
			$severeCases[] = $row;
			$i++;
		}

		$treatedCases = [];
		foreach ( $simpleCases as $key => $val ) {
			$treatedCases[] = array_merge($simpleCases[$key], $severeCases[$key]);
		}

		$treatedCases = array_map( function( $case ) {
			$case['Month'] =$this->month;
			$case['Year'] = $this->year;
			$case['Code_OD_T'] = $this->getCodeOD( $case['ODName'] );
			unset( $case['ODName'] );
			$case['Total_M'] = $case['Simple_Total_M']  + $case['Severe_Total_M'];
			$case['Total_F'] = $case['Simple_Total_F'] + $case['Severe_Total_F'];
			$case['Total']   = $case['Simple_Total_M'] + $case['Simple_Total_F'] + $case['Severe_Total_M'] + $case['Severe_Total_F'];
			$case['InitTime'] = sqlNow();
			return $case;
		}, $treatedCases);

		$treatedCases = notInArray($treatedCases, [0], 'Code_OD_T');

		$this->db->insert_batch('tblHisTreat', $treatedCases);

		return '';
	}

	private function getTreatedCase($excel, $sheetName)
	{
		$type = substr($sheetName, 0,-11);

		$ipds = [
			'SimpleMalaria-IPD',
			'SevereMalaria-IPD'
		];

		$docNames = [
			'Simple Malaria - Outpatient New Cases',
			'Severe Malaria - Outpatient New Cases',
			'Simple Malaria - Inpatient Discharged Clients',
			'Severe Malaria - Inpatient Discharged Clients'
		];

		$sheet = $excel->getSheetByName($sheetName);

		if( empty($sheet) ) return 'Upload Wrong document!';

		$data = $sheet->toArray(null, true, true, true);

		$docName = $data[1]['A'];
		$date = $data[3]['A'];
		$date = explode('-', $date);

		if ( !in_array($docName, $docNames) ) return 'Upload wrong document!';

		$this->month = str_pad(monthToInt($date[0]), 2 ,0 ,STR_PAD_LEFT);
		$this->year = $date[1];

		$isExist = $this->isExist('treat');

		if ( $isExist ) return 'Treat Data already exist!';

		$i = 1;
		$cases = [];
		$odTmp = '';

		foreach ($data as $value) {

			if( $i < 9 ) {
				$i++;
				continue;
			}

			if( !empty($value['B']) && $i == 9 ) $odTmp = $value['B'];
			if( !empty($value['B']) && $i != 9 && substr($value['B'], -2) != 'PH' ) $odTmp = $value['B'];

			if( $value['C'] == 'Total By OD' ) {
				$case = [];
				if ( in_array($sheetName, $ipds) ) {
					$case = [
						'ODName' => $odTmp,
						$type . '_U_1_M' => str_replace(',', '', $value['F']) + str_replace(',', '', $value['J']),
						$type . '_U_1_F' => str_replace(',', '', $value['G']) + str_replace(',', '', $value['K']),
						$type . '_1_4_M' => str_replace(',', '', $value['N']),
						$type . '_1_4_F' => str_replace(',', '', $value['O']),
						$type . '_5_14_M'	=> str_replace(',', '', $value['R']),
						$type . '_5_14_F'	=> str_replace(',', '', $value['S']),
						$type . '_15_24_M'	=> str_replace(',', '', $value['V']),
						$type . '_15_24_F'	=> str_replace(',', '', $value['W']),
						$type . '_25_49_M'	=> str_replace(',', '', $value['Z']),
						$type . '_25_49_F'	=> str_replace(',', '', $value['AA']),
						$type . '_50_64_M'	=> str_replace(',', '', $value['AD']),
						$type . '_50_64_F'	=> str_replace(',', '', $value['AE']),
						$type . '_Over_65_M' => str_replace(',', '', $value['AH']),
						$type . '_Over_65_F' => str_replace(',', '', $value['AI']),
						$type . '_Total_M' => str_replace(',', '', $value['AL']),
						$type . '_Total_F' => str_replace(',', '', $value['AM']),
						$type . '_Referred_M' => str_replace(',', '', $value['AP']),
						$type . '_Referred_F' => str_replace(',', '', $value['AQ']),

						'IPD_U_5'	=> str_replace(',', '', $value['F']) + str_replace(',', '', $value['J']) + str_replace(',', '', $value['G']) + str_replace(',', '', $value['K']) + str_replace(',', '', $value['N']) + str_replace(',', '', $value['O']),
						'IPD_Over_5'=> str_replace(',', '', $value['AL']) + str_replace(',', '', $value['AM']) - (str_replace(',', '', $value['F']) + str_replace(',', '', $value['J']) + str_replace(',', '', $value['G']) + str_replace(',', '', $value['K']) + str_replace(',', '', $value['N']) + str_replace(',', '', $value['O'])),
						'IPD_F'		=> str_replace(',', '', $value['AM']),
						'IPD_Death'	=> str_replace(',', '', $value['AN']) + str_replace(',', '', $value['AO']),
						'IPD_Severe'=> $type == 'Severe' ? str_replace(',', '', $value['AL']) + str_replace(',', '', $value['AM']) : 0
					];
				} else {
					$case = [
						'ODName' => $odTmp,
						$type . '_U_1_M' => str_replace(',', '', $value['F']) + str_replace(',', '', $value['H']),
						$type . '_U_1_F' => str_replace(',', '', $value['G']) + str_replace(',', '', $value['I']),
						$type . '_1_4_M' => str_replace(',', '', $value['J']),
						$type . '_1_4_F' => str_replace(',', '', $value['K']),
						$type . '_5_14_M' => str_replace(',', '', $value['L']),
						$type . '_5_14_F' => str_replace(',', '', $value['M']),
						$type . '_15_24_M' => str_replace(',', '', $value['N']),
						$type . '_15_24_F' => str_replace(',', '', $value['O']),
						$type . '_25_49_M' => str_replace(',', '', $value['P']),
						$type . '_25_49_F' => str_replace(',', '', $value['Q']),
						$type . '_50_64_M' => str_replace(',', '', $value['R']),
						$type . '_50_64_F' => str_replace(',', '', $value['S']),
						$type . '_Over_65_M' => str_replace(',', '', $value['T']),
						$type . '_Over_65_F' => str_replace(',', '', $value['U']),
						$type . '_Total_M' => str_replace(',', '', $value['V']),
						$type . '_Total_F' => str_replace(',', '', $value['W']),
						$type . '_Referred_M' => str_replace(',', '', $value['X']),
						$type . '_Referred_F' => str_replace(',', '', $value['Y']),

						'OPD_U_5'	=> str_replace(',', '', $value['F']) + str_replace(',', '', $value['H']) + str_replace(',', '', $value['G']) + str_replace(',', '', $value['I']) + str_replace(',', '', $value['J']) + str_replace(',', '', $value['K']),
						'OPD_Over_5'=> str_replace(',', '', $value['V']) + str_replace(',', '', $value['W']) - (str_replace(',', '', $value['F']) + str_replace(',', '', $value['H']) + str_replace(',', '', $value['G']) + str_replace(',', '', $value['I']) + str_replace(',', '', $value['J']) + str_replace(',', '', $value['K'])),
						'OPD_F'		=> str_replace(',', '', $value['W']),
						'OPD_Death'	=> 0,
						'OPD_Severe'=> $type == 'Severe' ? str_replace(',', '', $value['V']) + str_replace(',', '', $value['W']) : 0
					];
				}

				array_push($cases, $case);
			}
			$i++;
		} // LOOP

		return $cases;
	}

	private function confirmDipstick($excel)
	{
		$sheet = $excel->getActiveSheet();
		$data = $sheet->toArray(null, true, true, true);

		$docName = $data[1]['A'];
		$date = $data[3]['A'];
		$date = explode('-', $date);

		$this->month = str_pad(monthToInt($date[0]), 2 ,0 ,STR_PAD_LEFT);
		$this->year = $date[1];

		//if ($docName != 'Malaria - Dipstick Tests'){
		//    return 'Upload wrong document!';
		//}

		$isExist = $this->isExist('dipstick');
		if( $isExist ) return 'Dipstick is already exist!';

		$i = 1;
		$odTmp = '';
		$cases = [];

		foreach ($data as $value) {
			if($i < 9) {
				$i++;
				continue;
			}

			if(!empty($value['B']) && $i == 9) {
				$odTmp = $value['B'];
			}

			if(!empty($value['B']) && $i != 9 && substr($value['B'], -2) != 'PH') {
				$odTmp = $value['B'];
			}

			if( $value['C'] == 'Total By OD' ) {
				$codeOD = $this->getCodeOD($odTmp);
				if ( $codeOD == 0 ) continue;

				$nest = [
					'Year' => $this->year,
					'Month' => $this->month,
					'Code_OD_T' => $codeOD,
					'Positive_U_1_M' => str_replace(',', '',$value['F']) + str_replace(',', '',$value['P']),
					'Positive_U_1_F' => str_replace(',', '',$value['G']) + str_replace(',', '',$value['Q']),
					'Positive_1_4_M' => str_replace(',', '',$value['Z']),
					'Positive_1_4_F' => str_replace(',', '',$value['AA']),
					'Positive_5_14_M' => str_replace(',', '',$value['AJ']),
					'Positive_5_14_F' => str_replace(',', '',$value['AK']),
					'Positive_15_24_M' => str_replace(',', '',$value['AT']),
					'Positive_15_24_F' => str_replace(',', '',$value['AU']),
					'Positive_25_49_M' => str_replace(',', '',$value['BD']),
					'Positive_25_49_F' => str_replace(',', '',$value['BE']),
					'Positive_50_64_M' => str_replace(',', '',$value['BN']),
					'Positive_50_64_F' => str_replace(',', '',$value['BO']),
					'Positive_Over_65_M' => str_replace(',', '',$value['BX']),
					'Positive_Over_65_F' => str_replace(',', '',$value['BY']),
					'Positive_Total_M' => str_replace(',', '',$value['CH']),
					'Positive_Total_F' => str_replace(',', '',$value['CI']),
					'Positive_Total' => str_replace(',', '',$value['CH']) + str_replace(',', '',$value['CI']),

					'PF_U_1_M' => str_replace(',', '',$value['H']) + str_replace(',', '',$value['R']),
					'PF_U_1_F' => str_replace(',', '',$value['I']) + str_replace(',', '',$value['S']),
					'PF_1_4_M' => str_replace(',', '',$value['AB']),
					'PF_1_4_F' => str_replace(',', '',$value['AC']),
					'PF_5_14_M' => str_replace(',', '',$value['AL']),
					'PF_5_14_F' => str_replace(',', '',$value['AM']),
					'PF_15_24_M' => str_replace(',', '',$value['AV']),
					'PF_15_24_F' => str_replace(',', '',$value['AW']),
					'PF_25_49_M' => str_replace(',', '',$value['BF']),
					'PF_25_49_F' => str_replace(',', '',$value['BG']),
					'PF_50_64_M' => str_replace(',', '',$value['BP']),
					'PF_50_64_F' => str_replace(',', '',$value['BQ']),
					'PF_Over_65_M' => str_replace(',', '',$value['BZ']),
					'PF_Over_65_F' => str_replace(',', '',$value['CA']),
					'PF_Total_M' => str_replace(',', '',$value['CJ']),
					'PF_Total_F' => str_replace(',', '',$value['CK']),
					'PF_Total' => str_replace(',', '',$value['CJ']) + str_replace(',', '',$value['CK']),

					'PV_U_1_M' => str_replace(',', '',$value['J']) + str_replace(',', '',$value['T']),
					'PV_U_1_F' => str_replace(',', '',$value['K']) + str_replace(',', '',$value['U']),
					'PV_1_4_M' => str_replace(',', '',$value['AD']),
					'PV_1_4_F' => str_replace(',', '',$value['AE']),
					'PV_5_14_M' => str_replace(',', '',$value['AN']),
					'PV_5_14_F' => str_replace(',', '',$value['AO']),
					'PV_15_24_M' => str_replace(',', '',$value['AX']),
					'PV_15_24_F' => str_replace(',', '',$value['AY']),
					'PV_25_49_M' => str_replace(',', '',$value['BH']),
					'PV_25_49_F' => str_replace(',', '',$value['BI']),
					'PV_50_64_M' => str_replace(',', '',$value['BR']),
					'PV_50_64_F' => str_replace(',', '',$value['BS']),
					'PV_Over_65_M' => str_replace(',', '',$value['CB']),
					'PV_Over_65_F' => str_replace(',', '',$value['CC']),
					'PV_Total_M' => str_replace(',', '',$value['CL']),
					'PV_Total_F' => str_replace(',', '',$value['CM']),
					'PV_Total' => str_replace(',', '',$value['CL']) + str_replace(',', '',$value['CM']),

					'Mix_U_1_M' => str_replace(',', '',$value['L']) + str_replace(',', '',$value['V']),
					'Mix_U_1_F' => str_replace(',', '',$value['M']) + str_replace(',', '',$value['W']),
					'Mix_1_4_M' => str_replace(',', '',$value['AF']),
					'Mix_1_4_F' => str_replace(',', '',$value['AG']),
					'Mix_5_14_M' => str_replace(',', '',$value['AP']),
					'Mix_5_14_F' => str_replace(',', '',$value['AQ']),
					'Mix_15_24_M' => str_replace(',', '',$value['AZ']),
					'Mix_15_24_F' => str_replace(',', '',$value['BA']),
					'Mix_25_49_M' => str_replace(',', '',$value['BJ']),
					'Mix_25_49_F' => str_replace(',', '',$value['BK']),
					'Mix_50_64_M' => str_replace(',', '',$value['BT']),
					'Mix_50_64_F' => str_replace(',', '',$value['BU']),
					'Mix_Over_65_M' => str_replace(',', '',$value['CD']),
					'Mix_Over_65_F' => str_replace(',', '',$value['CE']),
					'Mix_Total_M' => str_replace(',', '',$value['CN']),
					'Mix_Total_F' => str_replace(',', '',$value['CO']),
					'Mix_Total' => str_replace(',', '',$value['CN']) + str_replace(',', '',$value['CO']),

					'Negative_U_1_M' => str_replace(',', '',$value['N']) + str_replace(',', '',$value['X']),
					'Negative_U_1_F' => str_replace(',', '',$value['O']) + str_replace(',', '',$value['Y']),
					'Negative_1_4_M' => str_replace(',', '',$value['AH']),
					'Negative_1_4_F' => str_replace(',', '',$value['AI']),
					'Negative_5_14_M' => str_replace(',', '',$value['AR']),
					'Negative_5_14_F' => str_replace(',', '',$value['AS']),
					'Negative_15_24_M' => str_replace(',', '',$value['BB']),
					'Negative_15_24_F' => str_replace(',', '',$value['BC']),
					'Negative_25_49_M' => str_replace(',', '',$value['BL']),
					'Negative_25_49_F' => str_replace(',', '',$value['BM']),
					'Negative_50_64_M' => str_replace(',', '',$value['BV']),
					'Negative_50_64_F' => str_replace(',', '',$value['BW']),
					'Negative_Over_65_M' => str_replace(',', '',$value['CF']),
					'Negative_Over_65_F' => str_replace(',', '',$value['CG']),
					'Negative_Total_M' => str_replace(',', '',$value['CP']),
					'Negative_Total_F' => str_replace(',', '',$value['CQ']),
					'Negative_Total' => str_replace(',', '',$value['CP']) + str_replace(',', '',$value['CQ']),
					'InitTime' => sqlNow(),
				];

				$cases[] = $nest;
			}

			$i++;
		}//loop

		$this->db->insert_batch('tblHisDipstick', $cases);

		return '';
	}

	private function confirmSlide($excel)
	{
		$sheet = $excel->getActiveSheet();
		$data = $sheet->toArray(null, true, true, true);

		$docName = $data[1]['A'];
		$date = $data[3]['A'];
		$date = explode('-', $date);

		$this->month = str_pad(monthToInt($date[0]), 2 ,0 ,STR_PAD_LEFT);
		$this->year = $date[1];

		//if ($docName != 'Malaria - Slide Tests'){
		//    return 'Upload wrong document!';
		//}

		$isExist = $this->isExist('slide');
		if( $isExist ) return 'Slide data already exist!';

		$i = 1;
		$odTmp = '';
		$cases = [];

		foreach ($data as $value) {
			if($i < 9) {
				$i++;
				continue;
			}

			if(!empty($value['B']) && $i == 9) {
				$odTmp = $value['B'];
			}

			if(!empty($value['B']) && $i != 9 && substr($value['B'], -2) != 'PH') {
				$odTmp = $value['B'];
			}

			if($value['C'] == 'Total By OD') {
				$codeOD = $this->getCodeOD($odTmp);
				if ( $codeOD == 0 ) continue;

				$nest = [
					'Year' => $this->year,
					'Month' => $this->month,
					'Code_OD_T' => $codeOD,
					'Positive_U_1_M' => str_replace(',', '',$value['F']) + str_replace(',', '',$value['P']),
					'Positive_U_1_F' => str_replace(',', '',$value['G']) + str_replace(',', '',$value['Q']),
					'Positive_1_4_M' => str_replace(',', '',$value['Z']),
					'Positive_1_4_F' => str_replace(',', '',$value['AA']),
					'Positive_5_14_M' => str_replace(',', '',$value['AJ']),
					'Positive_5_14_F' => str_replace(',', '',$value['AK']),
					'Positive_15_24_M' => str_replace(',', '',$value['AT']),
					'Positive_15_24_F' => str_replace(',', '',$value['AU']),
					'Positive_25_49_M' => str_replace(',', '',$value['BD']),
					'Positive_25_49_F' => str_replace(',', '',$value['BE']),
					'Positive_50_64_M' => str_replace(',', '',$value['BN']),
					'Positive_50_64_F' => str_replace(',', '',$value['BO']),
					'Positive_Over_65_M' => str_replace(',', '',$value['BX']),
					'Positive_Over_65_F' => str_replace(',', '',$value['BY']),
					'Positive_Total_M' => str_replace(',', '',$value['CH']),
					'Positive_Total_F' => str_replace(',', '',$value['CI']),
					'Positive_Total' => str_replace(',', '',$value['CH']) + str_replace(',', '',$value['CI']),

					'PF_U_1_M' => str_replace(',', '',$value['H']) + str_replace(',', '',$value['R']),
					'PF_U_1_F' => str_replace(',', '',$value['I']) + str_replace(',', '',$value['S']),
					'PF_1_4_M' => str_replace(',', '',$value['AB']),
					'PF_1_4_F' => str_replace(',', '',$value['AC']),
					'PF_5_14_M' => str_replace(',', '',$value['AL']),
					'PF_5_14_F' => str_replace(',', '',$value['AM']),
					'PF_15_24_M' => str_replace(',', '',$value['AV']),
					'PF_15_24_F' => str_replace(',', '',$value['AW']),
					'PF_25_49_M' => str_replace(',', '',$value['BF']),
					'PF_25_49_F' => str_replace(',', '',$value['BG']),
					'PF_50_64_M' => str_replace(',', '',$value['BP']),
					'PF_50_64_F' => str_replace(',', '',$value['BQ']),
					'PF_Over_65_M' => str_replace(',', '',$value['BZ']),
					'PF_Over_65_F' => str_replace(',', '',$value['CA']),
					'PF_Total_M' => str_replace(',', '',$value['CJ']),
					'PF_Total_F' => str_replace(',', '',$value['CK']),
					'PF_Total' => str_replace(',', '',$value['CJ']) + str_replace(',', '',$value['CK']),

					'PV_U_1_M' => str_replace(',', '',$value['J']) + str_replace(',', '',$value['T']),
					'PV_U_1_F' => str_replace(',', '',$value['K']) + str_replace(',', '',$value['U']),
					'PV_1_4_M' => str_replace(',', '',$value['AD']),
					'PV_1_4_F' => str_replace(',', '',$value['AE']),
					'PV_5_14_M' => str_replace(',', '',$value['AN']),
					'PV_5_14_F' => str_replace(',', '',$value['AO']),
					'PV_15_24_M' => str_replace(',', '',$value['AX']),
					'PV_15_24_F' => str_replace(',', '',$value['AY']),
					'PV_25_49_M' => str_replace(',', '',$value['BH']),
					'PV_25_49_F' => str_replace(',', '',$value['BI']),
					'PV_50_64_M' => str_replace(',', '',$value['BR']),
					'PV_50_64_F' => str_replace(',', '',$value['BS']),
					'PV_Over_65_M' => str_replace(',', '',$value['CB']),
					'PV_Over_65_F' => str_replace(',', '',$value['CC']),
					'PV_Total_M' => str_replace(',', '',$value['CL']),
					'PV_Total_F' => str_replace(',', '',$value['CM']),
					'PV_Total' => str_replace(',', '',$value['CL']) + str_replace(',', '',$value['CM']),

					'Mix_U_1_M' => str_replace(',', '',$value['L']) + str_replace(',', '',$value['V']),
					'Mix_U_1_F' => str_replace(',', '',$value['M']) + str_replace(',', '',$value['W']),
					'Mix_1_4_M' => str_replace(',', '',$value['AF']),
					'Mix_1_4_F' => str_replace(',', '',$value['AG']),
					'Mix_5_14_M' => str_replace(',', '',$value['AP']),
					'Mix_5_14_F' => str_replace(',', '',$value['AQ']),
					'Mix_15_24_M' => str_replace(',', '',$value['AZ']),
					'Mix_15_24_F' => str_replace(',', '',$value['BA']),
					'Mix_25_49_M' => str_replace(',', '',$value['BJ']),
					'Mix_25_49_F' => str_replace(',', '',$value['BK']),
					'Mix_50_64_M' => str_replace(',', '',$value['BT']),
					'Mix_50_64_F' => str_replace(',', '',$value['BU']),
					'Mix_Over_65_M' => str_replace(',', '',$value['CD']),
					'Mix_Over_65_F' => str_replace(',', '',$value['CE']),
					'Mix_Total_M' => str_replace(',', '',$value['CN']),
					'Mix_Total_F' => str_replace(',', '',$value['CO']),
					'Mix_Total' => str_replace(',', '',$value['CN']) + str_replace(',', '',$value['CO']),

					'Negative_U_1_M' => str_replace(',', '',$value['N']) + str_replace(',', '',$value['X']),
					'Negative_U_1_F' => str_replace(',', '',$value['O']) + str_replace(',', '',$value['Y']),
					'Negative_1_4_M' => str_replace(',', '',$value['AH']),
					'Negative_1_4_F' => str_replace(',', '',$value['AI']),
					'Negative_5_14_M' => str_replace(',', '',$value['AR']),
					'Negative_5_14_F' => str_replace(',', '',$value['AS']),
					'Negative_15_24_M' => str_replace(',', '',$value['BB']),
					'Negative_15_24_F' => str_replace(',', '',$value['BC']),
					'Negative_25_49_M' => str_replace(',', '',$value['BL']),
					'Negative_25_49_F' => str_replace(',', '',$value['BM']),
					'Negative_50_64_M' => str_replace(',', '',$value['BV']),
					'Negative_50_64_F' => str_replace(',', '',$value['BW']),
					'Negative_Over_65_M' => str_replace(',', '',$value['CF']),
					'Negative_Over_65_F' => str_replace(',', '',$value['CG']),
					'Negative_Total_M' => str_replace(',', '',$value['CP']),
					'Negative_Total_F' => str_replace(',', '',$value['CQ']),
					'Negative_Total' => str_replace(',', '',$value['CP']) + str_replace(',', '',$value['CQ']),
					'InitTime' => sqlNow(),
				];

				$cases[] = $nest;
			}

			$i++;
		}

		$this->db->insert_batch('tblHisSlide', $cases);

		return '';
	}

	private function vmw($excel)
	{
		$sheet = $excel->getActiveSheet();
		$data = $sheet->toArray(null, true, true, true);

		$docName = $data[1]['A'];
		$date = $data[3]['A'];
		$date = explode('-', $date);

		$this->month = str_pad(monthToInt($date[0]), 2 ,0 ,STR_PAD_LEFT);
		$this->year = $date[1];

		//if ($docName != 'Malaria - Dipstick Tests by Village Malaria Workers'){
		//    return 'Upload wrong document!';
		//}

		$isExist = $this->isExist('vmw');
		if( $isExist ) return 'VMW data already exist!';

		$i = 1;
		$odTmp = '';
		$cases = [];

		foreach ($data as $value) {
			if($i < 8) {
				$i++;
				continue;
			}

			if(!empty($value['B']) && $i == 8) {
				$odTmp = $value['B'];
			}

			if(!empty($value['B']) && $i != 8 && substr($value['B'], -2) != 'PH') {
				$odTmp = $value['B'];
			}

			if($value['C'] == 'Total By OD') {
				$codeOD = $this->getCodeOD($odTmp);
				if ( $codeOD == 0 ) continue;

				$nest = [
					'Year' => $this->year,
					'Month' => $this->month,
					'Code_OD_T' => $codeOD,
					'Positive_U_1_M' => str_replace(',', '',$value['F']) + str_replace(',', '',$value['P']),
					'Positive_U_1_F' => str_replace(',', '',$value['G']) + str_replace(',', '',$value['Q']),
					'Positive_1_4_M' => str_replace(',', '',$value['Z']),
					'Positive_1_4_F' => str_replace(',', '',$value['AA']),
					'Positive_5_14_M' => str_replace(',', '',$value['AJ']),
					'Positive_5_14_F' => str_replace(',', '',$value['AK']),
					'Positive_15_24_M' => str_replace(',', '',$value['AT']),
					'Positive_15_24_F' => str_replace(',', '',$value['AU']),
					'Positive_25_49_M' => str_replace(',', '',$value['BD']),
					'Positive_25_49_F' => str_replace(',', '',$value['BE']),
					'Positive_50_64_M' => str_replace(',', '',$value['BN']),
					'Positive_50_64_F' => str_replace(',', '',$value['BO']),
					'Positive_Over_65_M' => str_replace(',', '',$value['BX']),
					'Positive_Over_65_F' => str_replace(',', '',$value['BY']),
					'Positive_Total_M' => str_replace(',', '',$value['CH']),
					'Positive_Total_F' => str_replace(',', '',$value['CI']),
					'Positive_Total' => str_replace(',', '',$value['CH']) + str_replace(',', '',$value['CI']),

					'PF_U_1_M' => str_replace(',', '',$value['H']) + str_replace(',', '',$value['R']),
					'PF_U_1_F' => str_replace(',', '',$value['I']) + str_replace(',', '',$value['S']),
					'PF_1_4_M' => str_replace(',', '',$value['AB']),
					'PF_1_4_F' => str_replace(',', '',$value['AC']),
					'PF_5_14_M' => str_replace(',', '',$value['AL']),
					'PF_5_14_F' => str_replace(',', '',$value['AM']),
					'PF_15_24_M' => str_replace(',', '',$value['AV']),
					'PF_15_24_F' => str_replace(',', '',$value['AW']),
					'PF_25_49_M' => str_replace(',', '',$value['BF']),
					'PF_25_49_F' => str_replace(',', '',$value['BG']),
					'PF_50_64_M' => str_replace(',', '',$value['BP']),
					'PF_50_64_F' => str_replace(',', '',$value['BQ']),
					'PF_Over_65_M' => str_replace(',', '',$value['BZ']),
					'PF_Over_65_F' => str_replace(',', '',$value['CA']),
					'PF_Total_M' => str_replace(',', '',$value['CJ']),
					'PF_Total_F' => str_replace(',', '',$value['CK']),
					'PF_Total' => str_replace(',', '',$value['CJ']) + str_replace(',', '',$value['CK']),

					'PV_U_1_M' => str_replace(',', '',$value['J']) + str_replace(',', '',$value['T']),
					'PV_U_1_F' => str_replace(',', '',$value['K']) + str_replace(',', '',$value['U']),
					'PV_1_4_M' => str_replace(',', '',$value['AD']),
					'PV_1_4_F' => str_replace(',', '',$value['AE']),
					'PV_5_14_M' => str_replace(',', '',$value['AN']),
					'PV_5_14_F' => str_replace(',', '',$value['AO']),
					'PV_15_24_M' => str_replace(',', '',$value['AX']),
					'PV_15_24_F' => str_replace(',', '',$value['AY']),
					'PV_25_49_M' => str_replace(',', '',$value['BH']),
					'PV_25_49_F' => str_replace(',', '',$value['BI']),
					'PV_50_64_M' => str_replace(',', '',$value['BR']),
					'PV_50_64_F' => str_replace(',', '',$value['BS']),
					'PV_Over_65_M' => str_replace(',', '',$value['CB']),
					'PV_Over_65_F' => str_replace(',', '',$value['CC']),
					'PV_Total_M' => str_replace(',', '',$value['CL']),
					'PV_Total_F' => str_replace(',', '',$value['CM']),
					'PV_Total' => str_replace(',', '',$value['CL']) + str_replace(',', '',$value['CM']),

					'Mix_U_1_M' => str_replace(',', '',$value['L']) + str_replace(',', '',$value['V']),
					'Mix_U_1_F' => str_replace(',', '',$value['M']) + str_replace(',', '',$value['W']),
					'Mix_1_4_M' => str_replace(',', '',$value['AF']),
					'Mix_1_4_F' => str_replace(',', '',$value['AG']),
					'Mix_5_14_M' => str_replace(',', '',$value['AP']),
					'Mix_5_14_F' => str_replace(',', '',$value['AQ']),
					'Mix_15_24_M' => str_replace(',', '',$value['AZ']),
					'Mix_15_24_F' => str_replace(',', '',$value['BA']),
					'Mix_25_49_M' => str_replace(',', '',$value['BJ']),
					'Mix_25_49_F' => str_replace(',', '',$value['BK']),
					'Mix_50_64_M' => str_replace(',', '',$value['BT']),
					'Mix_50_64_F' => str_replace(',', '',$value['BU']),
					'Mix_Over_65_M' => str_replace(',', '',$value['CD']),
					'Mix_Over_65_F' => str_replace(',', '',$value['CE']),
					'Mix_Total_M' => str_replace(',', '',$value['CN']),
					'Mix_Total_F' => str_replace(',', '',$value['CO']),
					'Mix_Total' => str_replace(',', '',$value['CN']) + str_replace(',', '',$value['CO']),

					'Negative_U_1_M' => str_replace(',', '',$value['N']) + str_replace(',', '',$value['X']),
					'Negative_U_1_F' => str_replace(',', '',$value['O']) + str_replace(',', '',$value['Y']),
					'Negative_1_4_M' => str_replace(',', '',$value['AH']),
					'Negative_1_4_F' => str_replace(',', '',$value['AI']),
					'Negative_5_14_M' => str_replace(',', '',$value['AR']),
					'Negative_5_14_F' => str_replace(',', '',$value['AS']),
					'Negative_15_24_M' => str_replace(',', '',$value['BB']),
					'Negative_15_24_F' => str_replace(',', '',$value['BC']),
					'Negative_25_49_M' => str_replace(',', '',$value['BL']),
					'Negative_25_49_F' => str_replace(',', '',$value['BM']),
					'Negative_50_64_M' => str_replace(',', '',$value['BV']),
					'Negative_50_64_F' => str_replace(',', '',$value['BW']),
					'Negative_Over_65_M' => str_replace(',', '',$value['CF']),
					'Negative_Over_65_F' => str_replace(',', '',$value['CG']),
					'Negative_Total_M' => str_replace(',', '',$value['CP']),
					'Negative_Total_F' => str_replace(',', '',$value['CQ']),
					'Negative_Total' => str_replace(',', '',$value['CP']) + str_replace(',', '',$value['CQ']),
					'InitTime' => sqlNow(),
				];

				$cases[] = $nest;
			}

			$i++;
		}

		$this->db->insert_batch('tblHisVMW', $cases);

		return '';
	}

	private function isExist($file)
	{
		$sql = '';
		if( $file == 'treat' ) $sql = "select * from tblHisTreat where Month = '{$this->month}' and Year = '{$this->year}'";
		if( $file == 'dipstick' ) $sql = "select * from tblHisDipstick where Month = '{$this->month}' and Year = '{$this->year}'";
		if( $file == 'slide' ) $sql = "select * from tblHisSlide where Month = '{$this->month}' and Year = '{$this->year}'";
		if( $file == 'vmw' ) $sql = "select * from tblHisVMW where Month = '{$this->month}' and Year = '{$this->year}'";

		$q = $this->db->query($sql);
		if($q->num_rows()) return true;
		return false;
	}

	private function getCodeOD($name)
	{
		$name = trim($name);
		$sql = "select * from tblOD where Name_OD_E = '{$name}'";
		$row = $this->db->query($sql)->row();
		if(empty($row)) {
			return 0;
		}

		return $row->Code_OD_T;
	}

	public function getData()
	{
		$year = $this->input->post('year');

		$sql = "select distinct a.Month, a.Year,
				iif(a.Rec_ID is null, 0, 1) as Treat,
				iif(b.Rec_ID is null, 0, 1) as Dipstick,
				iif(c.Rec_ID is null, 0, 1) as Slide,
				iif(d.Rec_ID is null, 0, 1) as VMW
				from tblHisTreat as a
				 join tblHisDipstick as b on a.Code_OD_T = b.Code_OD_T and a.Year = b.Year and a.Month = b.Month
				 join tblHisSlide as c on a.Code_OD_T = c.Code_OD_T and a.Year = c.Year and a.Month = c.Month
				 join tblHisVMW as d on a.Code_OD_T = d.Code_OD_T and a.Year = d.Year and a.Month = d.Month
				where a.Year = {$year} order by a.Month";

		$rs = $this->db->query($sql)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDetail()
	{
		$year = $this->input->post('year');;
		$month = $this->input->post('month');

		$sql = "select b.Name_OD_E, a.* from tblHisTreat as a
				join tblOD as b on a.Code_OD_T = b.Code_OD_T
				where Year = {$year} and Month = {$month}";

		$rs['treat'] = $this->db->query($sql)->result_array();

		array_walk($rs['treat'], function (&$a, $k) {
			unset($a['InitTime'], $a['Rec_ID'], $a['Code_OD_T']);
		});


		$sql = "select b.Name_OD_E, a.* from tblHisDipstick as a
				join tblOD as b on a.Code_OD_T = b.Code_OD_T
				where Year = {$year} and Month = {$month}";

		$rs['dipstick'] = $this->db->query($sql)->result_array();

		array_walk($rs['dipstick'], function (&$a, $k) {
			unset($a['InitTime'], $a['Rec_ID'], $a['Code_OD_T']);
		});

		$sql = "select b.Name_OD_E, a.* from tblHisSlide as a
				join tblOD as b on a.Code_OD_T = b.Code_OD_T
				where Year = {$year} and Month = {$month}";

		$rs['slide'] = $this->db->query($sql)->result_array();

		array_walk($rs['slide'], function (&$a, $k) {
			unset($a['InitTime'], $a['Rec_ID'], $a['Code_OD_T']);
		});

		$sql = "select b.Name_OD_E, a.* from tblHisVMW as a
				join tblOD as b on a.Code_OD_T = b.Code_OD_T
				where Year = {$year} and Month = {$month}";

		$rs['vmw'] = $this->db->query($sql)->result_array();

		array_walk($rs['vmw'], function (&$a, $k) {
			unset($a['InitTime'], $a['Rec_ID'], $a['Code_OD_T']);
		});

		$this->output->set_output(json_encode($rs));
	}

	public function getReport()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');

		$rs = $this->db->query("SP_MisHis {$year}, '{$month}'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getDiscrepancy()
	{
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		
		$rs = $this->db->query("SP_MisHisDiscrepancy {$year}, '{$month}'")->result();

		$this->output->set_output(json_encode($rs));
	}

	public function delete()
	{
		$year = $this->input->post('Year');
		$month = $this->input->post('Month');

		$where['Year'] = $year;
		$where['Month'] = $month;

		$this->db->delete('tblHisTreat', $where);
		$this->db->delete('tblHisSlide', $where);
		$this->db->delete('tblHisDipstick', $where);
		$this->db->delete('tblHisVMW', $where);

		$this->output->set_output(1);
	}
}