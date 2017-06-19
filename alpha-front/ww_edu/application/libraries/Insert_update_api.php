<?php  

class Insert_update_api extends sql_operation
{
	use date_format;

	private $_array = [];
	private $datas_before = [];

	public function init($json_data, $datas_before)
	{
		$decode_data = $this->jsonDecode($json_data);
		$this->_array = $decode_data;
		$this->datas_before = $datas_before;

		return $this;
	}

	public function property($callback, $param = [])
	{
		$this->property = call_user_func_array([$this, $callback], $param);
	}

	protected function comparison()
	{
		$needUpdate = $this->_array;
		$compa = array_flip(array_column($this->datas_before, 'md5', 'id'));
		foreach ($needUpdate as $key => $value) {
			foreach ($value as $k => $v) {
				if ($k == 'md5') {
					$needUpdate[$key] = $compa[$k];
				}
			}
		}
		print_r($needUpdate);
	}
}