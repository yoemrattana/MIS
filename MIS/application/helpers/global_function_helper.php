<?php

function latestJs($filepath)
{
	$time = filemtime(FCPATH . $filepath);
	return "<script src='$filepath?$time'></script>";
}

function latestCss($filepath)
{
	$time = filemtime(FCPATH . $filepath);
	return "<link href='$filepath?$time' rel='stylesheet' />";
}

function latestFile($filepath)
{
	$time = filemtime(FCPATH . $filepath);
	return "$filepath?$time";
}

function strContain($string, $find)
{
	return strpos($string, $find) !== false;
}

function sqlNow()
{
	return substr(date_create()->format('Y-m-d H:i:s.u'), 0, 23);
}

function show_unauthorized()
{
    show_error('You are not authorized to access.', 401, 'Unauthorized');
}

function readPlaceUpdate()
{
	$ci = get_instance();
	$pu = $ci->db->get_where('tblSetting', ['Name' => 'PlaceUpdate'])->row('Value');
	$pu = json_decode($pu, true);
	if ($pu == null) $pu = [];
	if (!isset($pu['pv'])) $pu['pv'] = microtime(true);
	if (!isset($pu['od'])) $pu['od'] = microtime(true);
	if (!isset($pu['hc'])) $pu['hc'] = microtime(true);
	if (!isset($pu['ds'])) $pu['ds'] = microtime(true);
	if (!isset($pu['cm'])) $pu['cm'] = microtime(true);
	if (!isset($pu['vl'])) $pu['vl'] = microtime(true);
	if (!isset($pu['rg'])) $pu['rg'] = microtime(true);
	if (!isset($pu['rgpv'])) $pu['rgpv'] = microtime(true);
	if (!isset($pu['gp'])) $pu['gp'] = microtime(true);
	if (!isset($pu['unit'])) $pu['unit'] = microtime(true);
	return $pu;
}

function writePlaceUpdate($name)
{
	$pu = readPlaceUpdate();
	$pu[$name] = microtime(true);
	$value['Value'] = json_encode($pu);
	$where['Name'] = 'PlaceUpdate';
	$ci = get_instance();
	$ci->db->update('tblSetting', $value, $where);
}

function arrayToExcel($array, $excel = null, $autoSize = true)
{
	if ($excel == null) {
		$ci = get_instance();
		$ci->load->library('PHPExcel');
		$excel = new PHPExcel();
	}
	$sheet = $excel->getActiveSheet();

	if (count($array) > 0) {
		$c = 0;
		foreach($array[0] as $key => $value)
		{
			$sheet->getColumnDimensionByColumn($c)->setAutoSize($autoSize);
			$sheet->getStyleByColumnAndRow($c)->getFont()->setBold(true);
			$sheet->setCellValueByColumnAndRow($c++, 1, $key);
		}

		$r = 2;
		foreach ($array as $row) {
			$c = 0;
			foreach ($row as $value) {
				if (!is_string($value)) $sheet->setCellValueByColumnAndRow($c++, $r, $value);
                else {
                    $isDate = strlen($value) == 10 && preg_match('/\d{4}-\d{2}-\d{2}/', $value) == 1;
                    $isDatetime = strlen($value) == 16 && preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}/', $value) == 1;

                    if ($isDate || $isDatetime) {
                        $sheet->setCellValueByColumnAndRow($c, $r, PHPExcel_Shared_Date::PHPToExcel($value));
                        $sheet->getStyleByColumnAndRow($c++, $r)->getNumberFormat()->setFormatCode($isDate ? 'dd-mm-yyyy' : 'dd-mm-yyyy hh:mm');
                    }
                    else $sheet->setCellValueExplicitByColumnAndRow($c++, $r, $value);
                }
			}
			$r++;
		}
	}

	return $excel;
}

function toInt($str)
{
	return (int)filter_var($str, FILTER_SANITIZE_NUMBER_INT);
}

function toFloat($str)
{
	return (float)filter_var($str, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function monthToInt(string $str)
{
	$str = strtolower(substr($str, 0, 3));
	$months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];
	return array_search($str, $months) + 1;
}

function intToMonth(int $number)
{
	$months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	return $months[$number - 1];
}

function GUID()
{
	return strtoupper(bin2hex(random_bytes(16)));
}

function writeApiInput($file = 'api_input.txt')
{
	$content = $_SERVER['PATH_INFO'] . "\n";
	if (strContain($content, '/MalariaRDT/malaria_rdt')) return;

	$ci = get_instance();
	$param = $_SERVER['REQUEST_METHOD'] == 'GET' ? $ci->get() : $ci->post();
	if (count($param) == 0) $param = new stdClass();
	$content .= json_encode($param, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

	$path = FCPATH . '\temp\\' . $file;
	$arr = [];
	if (file_exists($path)) $arr = explode("\n\n", file_get_contents($path));
	array_unshift($arr, $content);
	$arr = array_slice($arr, 0, 100);

	file_put_contents($path, implode("\n\n", $arr));
}

function addDay($date, $day)
{
	$date=date_create($date);
	date_add($date,date_interval_create_from_date_string("{$day} days"));
	return date_format($date,"Y-m-d");
}

function array_flatten($array, $withKey=false) {
	if (!is_array($array)) {
		return false;
	}
	$result = [];
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$result = array_merge($result, array_flatten($value, $withKey));
		} else {
			if($withKey){
				$result = array_merge($result, [$key=>$value]);
			} else {
				$result = array_merge($result, [$value]);
			}
		}
	}
	return $result;
}

function notInArray($initArr, $otherArr, $initArrIndex)
{
	$rs = array_filter($initArr, function($v, $k) use ($otherArr, $initArrIndex) {
		return !in_array($v[$initArrIndex], $otherArr);
	}, ARRAY_FILTER_USE_BOTH);
	return  array_values($rs); //reindex array
}

function ExportExcel($sql)
{
	set_time_limit(0);
	ini_set('memory_limit', '-1');

	$ci = get_instance();
	$db = $ci->db;

	$args['sql'] = $sql;
	$args['connectionString'] = "server={$db->hostname};database={$db->database};uid={$db->username};pwd={$db->password}";
	$args['tempfolder'] = FCPATH . '\temp';
	$submit = base64_encode(json_encode($args));

	$path = FCPATH . '\media\ExportExcel\MISExcel.exe';
	$filepathOrError = exec("\"$path\" ExportExcel $submit");
	if (strpos($filepathOrError, 'Error') === 0) {
		$error = 'MISExcel.exe: ' . base64_decode(explode(':', $filepathOrError)[1]);
		$error = str_replace("\r\n", '<br>', $error);
		show_error($error);
	}
	$ci->output->set_header('Content-Length: ' . filesize($filepathOrError));
	$ci->output->set_content_type('xlsx');
	$ci->output->set_output(file_get_contents($filepathOrError));
	unlink($filepathOrError);
}

function nvarchar($txt) {
    return $txt;
}