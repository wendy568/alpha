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
	}

	protected function comparison()
	{
		$compa = array_column($this->datas_before, 'md5', 'id');
		print_r($compa);
	}
}