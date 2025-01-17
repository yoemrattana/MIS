<?php
class MVMWQA extends CI_Model
{
	public function groupReport($sql)
	{
		$rs = $this->db->query($sql)->result_array();

		for ($i = 0; $i < count($rs); $i++)
		{
			$r = $rs[$i];
			$score = $r['TotalScore'];
			$tpr = $r['TPR'];

			$r['Section2'] = round($r['Section2'] * 100 / 35);
			$r['Section3'] = round($r['Section3'] * 100 / 35);
			$r['Section4'] = round($r['Section4'] * 100 / 15);
			$r['Section5'] = round($r['Section5'] * 100 / 5);
			$r['Section6'] = round($r['Section6'] * 100 / 5);
			$r['Section7'] = round($r['Section7'] * 100 / 5);

			$lowestSection = null;
			$lowestScore = 1;
			for ($n = 2; $n <= 7; $n++)
			{
				if ($score !== null) {
					$sectionScore = $r["Section$n"];
					if ($sectionScore < $lowestScore) {
						$lowestSection = $n;
						$lowestScore = $sectionScore;
					}
				}
				$rs[$i]["Section{$n}Priority"] = $this->getPriority($r["Section$n"], $tpr);
			}

			$priority = $this->getPriority($score, $tpr);
			$rs[$i]['NextVisit'] = $r['VisitDate'] == null ? 'Never access' : ($priority < 3 ? 'Overdue' : ($priority < 7 ? 'Next 30 days' : 'Next 90 days'));
			$rs[$i]['Priority'] = $priority;
			$rs[$i]['LowestSectionScore'] = $lowestSection;

			for ($n = 2; $n <= 7; $n++)
			{
				$a = $rs[$i]["Section$n"];
				$b = $rs[$i]["Section{$n}Priority"];

				unset($rs[$i]["Section$n"]);
				unset($rs[$i]["Section{$n}Priority"]);

				$rs[$i]["Section$n"] = $a;
				$rs[$i]["Section{$n}Priority"] = $b;
			}

			unset($rs[$i]['Positive']);
			unset($rs[$i]['Test']);
		}

		return $rs;
	}

	public function crossTabReport($sql)
	{
		$rs = $this->db->query($sql)->result_array();

		$keys = [
			'Code_Prov_T', 'Name_Prov_E', 'Name_Prov_K',
			'Code_OD_T', 'Name_OD_E', 'Name_OD_K',
			'Code_Facility_T', 'Name_Facility_E', 'Name_Facility_K',
			'Code_Vill_T', 'Name_Vill_E', 'Name_Vill_K',
			'VMWType', 'VisitDate', 'TotalScore'
		];

		$overall = 0;
		$expected = 0;
		$conducted = 0;
		$positive = 0;
		$test = 0;

		for ($i = 0; $i < count($rs); $i++)
		{
			$r = $rs[$i];
			$obj = [];

			foreach ($keys as $k) $obj[$k] = $r[$k];

			$tpr = $r['TPR'];
			$score = $r['TotalScore'];
			$priority = $this->getPriority($score, $tpr);

			$obj['NextVisit'] = $priority < 3 ? 'Overdue' : ($priority < 7 ? 'Next 30 days' : 'Next 90 days');
			$obj['Priority'] = $priority;

			$obj['Section2'] = round($r['Section2'] * 100 / 35);
			$obj['Section3'] = round($r['Section3'] * 100 / 35);
			$obj['Section4'] = round($r['Section4'] * 100 / 15);
			$obj['Section5'] = round($r['Section5'] * 100 / 5);
			$obj['Section6'] = round($r['Section6'] * 100 / 5);
			$obj['Section7'] = round($r['Section7'] * 100 / 5);

			for ($n = 2; $n <= 7; $n++)
			{
				$obj["Section{$n}Priority"] = $this->getPriority($obj["Section$n"], $tpr);
			}

			$rs[$i] = $obj;

			$overall += $score;
			$expected += $priority < 7 ? 1 : 0;
			$conducted += $score !== null ? 1 : 0;

			$positive += $r['Positive'];
			$test += $r['Test'];
		}

		$tpr = $test == 0 ? 0 : round($positive * 100 / $test);

		$result['Overall'] = count($rs) == 0 ? 0 : round($overall / count($rs));
		$result['Priority'] = $this->getPriority($result['Overall'], $tpr);
		$result['Expected'] = $expected;
		$result['Conducted'] = $conducted;
		$result['Detail'] = $rs;

		return $result;
	}

	public function getPriority($score, $tpr)
	{
		if ($score < 50) {
			if ($tpr > 10) $priority = 1;
			elseif ($tpr >= 5) $priority = 2;
			else $priority = 5;
		} elseif ($score < 80) {
			if ($tpr > 10) $priority = 3;
			elseif ($tpr >= 5) $priority = 4;
			else $priority = 7;
		} else {
			if ($tpr > 10) $priority = 6;
			elseif ($tpr >= 5) $priority = 8;
			else $priority = 9;
		}

		return $priority;
	}
}