<?php  

class Members extends sql_operation
{
	use struct;

	public function init($array)
	{
		$this->_data = $array;
		$this->_data['update_time'] = date('Y-m-d H:i:s', time());

		return $this;
	}

	public function format()
	{
		foreach ($this->_data as $key => $value) {
			$this->$key = $value;
		}

		$this->table = ['member', 'user_info'];

		return $this;
	}

	public function update($file = null)
	{
		$instance = & get_instance();
		$instance->load->helper('databases_filter');
		$instance->load->helper('set_source');
		$image = null;

		if(!empty($this->width) && !empty($this->height)) $image = get_image($this->width, $this->height, "{$this->file_path}");
		if($image) $this->_data[$file] = addslashes(json_encode(array("{$this->file_path}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = $this->table;

		$dfdb->set_query($cols, $this->_data)
		     ->filter_blank($cols)
			 ->update_complete($cols, array('member' => array('id'=>$this->uid), 'user_info' => ['mem_id' => $this->mid]));

		return $cols;
		
	}

}