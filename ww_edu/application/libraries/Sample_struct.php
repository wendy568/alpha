<?php  

class Sample_struct extends sql_operation
{
	use struct;

	public $time_filter_definition = 'u_time';
	
	public function init($array, $table)
	{
		$this->_data = $array;
		$this->_data['table'] = $table;
		$this->_data['u_time'] = time();
		$this->_data['update_time'] = date('Y-m-d H:i:s', time());

		return $this;
	}

	public function create_time()
	{
		$this->_data['create_time'] = date('Y-m-d H:i:s', time());
		$this->_data['c_time'] = time();

		return $this;
	}

}