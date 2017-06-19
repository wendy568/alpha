<?php  

class Insert_update_api extends sql_operation
{
	use date_format;

	private $_array = [];
	private $datas_before = [];

	public function init($json_data, $datas_before)
	{
		$encode_data = $this->jsonDecode($json_data);
		$this->_array = $encode_data;
		$this->datas_before = $datas_before;
		print_r($this->datas_before);
		print_r($this->_array);die;
	}
}