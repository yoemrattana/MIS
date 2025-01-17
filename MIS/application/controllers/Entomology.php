<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entomology extends MY_Controller
{
	public function index($view = 'entomology_view')
	{
		if (!isset($_SESSION['permiss']['Entomology'])) redirect('Home');

		$data['title'] = 'Entomology';
		$data['main'] = $view;
		$this->load->view('layout', $data);
	}

	public function mosquito()
	{
		$this->index('entomology_mosquito_view');
	}

	public function insecticide()
	{
		$this->index('entomology_insecticide_view');
	}

	public function dashboard()
	{
		$this->index('entomology_dashboard_view');
	}

	private function getMosquitoSql($id = 0)
	{
		return "select a.*, Code_Prov_T, Code_Dist_T, Code_Comm_T
				from tblEntomologyMosquito as a
				left join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				where $id = 0 or Rec_ID = $id
				order by CollectionDate";
	}

	private function getInsecticideSql($id = 0)
	{
		return "select a.*, Code_Prov_T, Code_Dist_T, Code_Comm_T
				from tblEntomologyInsecticide as a
				join tblCensusVillage as b on a.Code_Vill_T = b.Code_Vill_T
				where $id = 0 or Rec_ID = $id";
	}

	public function getMosquitoList()
	{
		$rs['list'] = $this->db->query($this->getMosquitoSql())->result();
		$rs['fieldData'] = $this->db->field_data('tblEntomologyMosquito');

		$this->output->set_output(json_encode($rs));
	}

	public function getInsecticideList()
	{
		$rs['list'] = $this->db->query($this->getInsecticideSql())->result();
		$rs['fieldData'] = $this->db->field_data('tblEntomologyInsecticide');

		$this->output->set_output(json_encode($rs));
	}

	public function getMosquitoDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblEntomologyMosquitoDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function getInsecticideDetail()
	{
		$where = $this->input->post();

		$rs = $this->db->get_where('tblEntomologyInsecticideDetail', $where)->result();

		$this->output->set_output(json_encode($rs));
	}

	public function saveMosquito()
	{
		$master = json_decode($this->input->post('master'), true);
		$details = json_decode($this->input->post('details'), true);

		$id = $master['Rec_ID'];
		unset($master['Rec_ID']);

		if ($id == null) {
			$this->db->insert('tblEntomologyMosquito', $master);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblEntomologyMosquito', $master, ['Rec_ID' => $id]);
		}

		for ($i = 0; $i < count($details); $i++)
		{
			$details[$i]['ParentId'] = $id;
			unset($details[$i]['Rec_ID']);
		}

		$this->db->delete('tblEntomologyMosquitoDetail', ['ParentId' => $id]);
		foreach ($details as $value)
		{
			$this->db->insert('tblEntomologyMosquitoDetail', $value);
		}

		$rs = $this->db->query($this->getMosquitoSql($id))->row();
		$this->output->set_output(json_encode($rs));
	}

	public function saveInsecticide()
	{
		$master = json_decode($this->input->post('master'), true);
		$details = json_decode($this->input->post('details'), true);

		$id = $master['Rec_ID'];
		unset($master['Rec_ID']);

		if ($id == null) {
			$this->db->insert('tblEntomologyInsecticide', $master);
			$id = $this->db->insert_id();
		} else {
			$this->db->update('tblEntomologyInsecticide', $master, ['Rec_ID' => $id]);
		}

		for ($i = 0; $i < count($details); $i++)
		{
			$details[$i]['ParentId'] = $id;
			unset($details[$i]['Rec_ID']);
		}

		$this->db->delete('tblEntomologyInsecticideDetail', ['ParentId' => $id]);
		$this->db->insert_batch('tblEntomologyInsecticideDetail', $details);

		$rs = $this->db->query($this->getInsecticideSql($id))->row();
		$this->output->set_output(json_encode($rs));
	}

	public function getFociNumber()
	{
		$sql = "select distinct FociNumber from tblEntomologyMosquito where FociNumber <> '' order by FociNumber";
		$rs = $this->db->query($sql)->result();
		$this->output->set_output(json_encode($rs));
	}

	public function getDashboard()
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
        $pv = $this->input->post('pv');
		$isFoci = $this->input->post('isFoci');
		$trap = $this->input->post('trap');

		$rs['pie'] = $this->db->query("SP_Entomology_Dashboard_Pie '$from','$to','$pv','$isFoci','$trap'")->result();
		$rs['map'] = $this->db->query("SP_Entomology_Dashboard_Map '$from','$to','$pv','$isFoci','$trap'")->result();
		$rs['mapFoci'] = $this->db->query("SP_Entomology_Dashboard_FociMap '$pv'")->result();
		$rs['monthlyBitingHDN'] = $this->db->query("SP_Entomology_Dashboard_MonthlyBitingHDN '$from','$to','$pv','$isFoci','$trap'")->result();
		$rs['monthlyBitingCDN'] = $this->db->query("SP_Entomology_Dashboard_MonthlyBitingCDN '$from','$to','$pv','$isFoci','$trap'")->result();
		$rs['monthlyBitingCDC'] = $this->db->query("SP_Entomology_Dashboard_MonthlyBitingCDC '$from','$to','$pv','$isFoci','$trap'")->result();
		$rs['monthlyBitingCBT'] = $this->db->query("SP_Entomology_Dashboard_MonthlyBitingCBT '$from','$to','$pv','$isFoci','$trap'")->result();
		$rs['fociTable'] = $this->db->query("SP_Entomology_Dashboard_FociTable '$from','$to','$pv','$trap'")->result();
		$rs['abdominalStage'] = $this->db->query("SP_Entomology_Dashboard_AbdominalStage '$from','$to','$pv','$isFoci','$trap'")->result();

        $this->getChartHourly($rs);
        $this->getChartMortality($rs);

		$this->output->set_output(json_encode($rs));
	}

	public function getChartHourly(&$rs = null)
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
        $pv = $this->input->post('pv');
		$isFoci = $this->input->post('isFoci');
		$trap = $this->input->post('trap');
		$hourlyFoci = $this->input->post('hourlyFoci');
		$hourlyMethod = $this->input->post('hourlyMethod');

		$rs['hourlyBiting'] = $this->db->query("SP_Entomology_Dashboard_HourlyBiting '$from','$to','$pv','$isFoci','$trap','$hourlyFoci','$hourlyMethod'")->result();

		if (count($rs) == 1) $this->output->set_output(json_encode($rs));
	}

    public function getChartMortality(&$rs = null)
	{
		$from = $this->input->post('from');
		$to = $this->input->post('to');
        $pv = $this->input->post('pv');
		$mortalitySpecies = $this->input->post('mortalitySpecies');

		$rs['mortality'] = $this->db->query("SP_Entomology_Dashboard_Mortality '$from','$to','$pv','$mortalitySpecies'")->result();

        if (count($rs) == 1)  $this->output->set_output(json_encode($rs));
	}

    public function logDelete()
    {
        $submit = $this->input->post('submit');
		$submit = json_decode($submit, true);

        $this->load->model('Log_model');
		$this->Log_model->deleteEntomo( $submit );
    }
}