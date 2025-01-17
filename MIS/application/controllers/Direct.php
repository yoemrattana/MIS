<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Direct extends MY_Controller
{
	private function prepare($func)
	{
		$submit = json_decode($this->input->post('submit'), true);

		if ($func == 'insert' || $func == 'update') {
			if (isset($submit['batch'])) {
				foreach ($submit['batch'] as $item) {
					if ($func == 'insert') {
						foreach ($item as $k => $v) {
							if (strtolower($v) == 'getdate()') $item[$k] = sqlNow();
						}
					} else {
						foreach ($item['value'] as $k => $v) {
							if (strtolower($v) == 'getdate()') $item['value'][$k] = sqlNow();
						}
					}
				}
			} else {
				foreach ($submit['value'] as $k => $v) {
					if (strtolower($v) == 'getdate()') $submit['value'][$k] = sqlNow();
				}
			}
		}

		if ($func == 'delete' || $func == 'update') {
			if (isset($submit['batch'])) {
				foreach ($submit['batch'] as $item) {
					if (!isset($item['where'])) show_error('Direct: where is empty');
				}
			} else {
				if (!isset($submit['where'])) show_error('Direct: where is empty');
			}
		}

		return $submit;
	}

	public function insert()
	{
		$submit = $this->prepare('insert');
		if (isset($submit['batch'])) {
			$this->db->insert_batch($submit['table'], $submit['batch']);
		} else {
			$this->db->insert($submit['table'], $submit['value']);
			$id = $this->db->insert_id();
			if (isset($submit['where'])) {
				foreach ($submit['where'] as $k => $v) {
					$submit['where'][$k] = $id;
				}
				$rs = $this->db->get_where($submit['table'], $submit['where'])->row();
			} else {
				$rs = $id;
			}
			$this->output->set_output(json_encode($rs));
		}
	}

	public function update()
	{
		$submit = $this->prepare('update');
		if (isset($submit['batch'])) {
			foreach ($submit['batch'] as $item) {
				$this->db->update($submit['table'], $item['value'], $item['where']);
			}
		} else {
			$this->db->update($submit['table'], $submit['value'], $submit['where']);
			$rs = $this->db->get_where($submit['table'], $submit['where'])->row();
			$this->output->set_output(json_encode($rs));
		}
	}

	public function delete()
	{
		$submit = $this->prepare('delete');
		$this->db->delete($submit['table'], $submit['where']);
	}
}