<?php  

class Insert_update_api extends sql_operation
{
	use date_format, struct;

	private $_array = [];
	private $datas_before = [];
	private $needUpdate = [];

	public function init($json_data, $datas_before)
	{
		$decode_data = $this->jsonDecode($json_data);
		$this->_array = $decode_data;
		$this->datas_before = $datas_before;

		return $this;
	}

	protected function comparison()
	{
		$this->needUpdate = $this->_array;
		$compa = array_flip(array_column($this->datas_before, 'md5', 'id'));
		foreach ($this->needUpdate as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == 'md5') {
					if (!empty($compa[$v])) {
						$this->needUpdate[$key]['id'] = $compa[$v];
						unset($this->_array[$key]);
					} else {
						unset($this->needUpdate[$key]);
					}
				}
			}
		}

	}

	public function iteration_update($table, &$response, &$count)
	{
		print_r($this->needUpdate);
		$instance = & get_instance();
		$instance->load->database();
		$instance->load->model('users');

		foreach ($this->needUpdate as $val) {
			$val['table'] = $table;
			$this->_data = $val;
			$cols = $this->format()->property('user_addslashes', [])->pickUpProperty()->update();
			$instance->users->iteration_update($cols, $response, $count);
		}
		
	}

	public function iteration_add($table, &$response, &$count)
	{
		$instance = & get_instance();
		$instance->load->database();
		$instance->load->model('users');

		foreach ($this->_array as $val) {
			$val['table'] = $table;
			$this->_data = $val;
			$cols = $this->format()->property('user_addslashes', [])->pickUpProperty()->add();
			$instance->users->iteration_add($cols, $response, $count);
		}
		
	}
}