<?php  

class Insert_update_api
{
	use date_format;

	private $_array = [];

	public function init($json_data)
	{
		$encode_data = jsonDecode($json_data);
		$this->_array = $encode_data;
		print_r($this->_array);die;
	}
}