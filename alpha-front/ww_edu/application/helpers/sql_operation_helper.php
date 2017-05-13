<?php  

abstract class sql_operation
{
	protected $_data;

	public function format($array)
	{
		$this->_data = $array;
		foreach ($this->_data as $key => $value) {
			$this->$key = $value;
		}

		return $this;
	}

	protected function add_addslashes($index)
	{
		isset($index) OR $index = array_keys($this->_data);

		if (is_array($index)) {
			$output = array();
			foreach ($index as $key) {
				$output[$key] = _fetch_from_array($this->_data, $key);
			}

			return $output;
		}

		if(isset($this->_data[$index]) && $this->_data[$index]) {
			return addslashes($this->_data[$index]);
		} else {
			return false;
		}
	}

	public function property($callback)
	{
		return $this->_data = call_user_func_array($callback, $this->_data);
	}

	public function add()
	{		
		$instance = & get_instance();
		$instance->load->helper('databases_filter');
		$instance->load->helper('set_source');
		$image = null;

		if(!empty($this->width) && !empty($this->height)) $image = get_image($this->width, $this->height, "{$this->file_path}");
		if($image) $this->image = addslashes(json_encode(array("{$this->file_path}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));
		$dfdb = databases_filter::build();
		$cols = array($this->table);

		$dfdb->set_query($cols, $this->_data)
		     ->filter_blank($cols)
			 ->insert_complete($cols);

		return $cols;
	}

	public function update()
	{

		$instance = & get_instance();
		$instance->load->helper('databases_filter');
		$instance->load->helper('set_source');
		$image = null;

		if(!empty($this->width) && !empty($this->height)) $image = get_image($this->width, $this->height, "{$this->file_path}");
		if($image) $this->image = addslashes(json_encode(array("{$this->file_path}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = array($this->table);

		$dfdb->set_query($cols, $this->_data)
		     ->filter_blank($cols)
			 ->update_complete($cols, array($this->table=>array('id'=>$this->id)));

		return $cols;
		
	}
}