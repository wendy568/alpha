<?php  

class Trading_log extends sql_operation
{
	public function init()
	{
		$this->_data['table'] = 'trading_log';
		$this->_data['u_time'] = time();
		
		return $this;
	}

	public function create_time()
	{
		$this->_data['create_time'] = date('Y-m-d H:i:s', time());
		$this->_data['c_time'] = time();

		return $this;
	}

}