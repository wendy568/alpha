<?php  

class Insert_update_api extends sql_operation
{
	use date_format;

	private $_array = [];

	public function init($json_data)
	{
		$encode_data = $this->jsonDecode($json_data);
		$this->_array = $encode_data;
		print_r($this->_array);die;
	}
}