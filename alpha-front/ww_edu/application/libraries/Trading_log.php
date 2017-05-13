<?php  

class Trading_log extends sql_operation
{
	public function result()
	{
		print_r($this->_data);
	}
}