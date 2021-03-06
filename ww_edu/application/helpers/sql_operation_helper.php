<?php  

abstract class sql_operation
{
	protected $_data = [];

	public function format()
	{
		foreach ($this->_data as $key => $value) {
			$this->$key = $value;
		}

		return $this;
	}

	public function pickUpProperty()
	{
		$this->_data = $this->property;
		return $this;
	}

	protected function user_addslashes($index = null)
	{
		isset($index) OR $index = array_keys($this->_data);

		if (is_array($index)) {
			$output = array();
			foreach ($index as $key) {
				$output[$key] = $this->user_addslashes($key);
			}

			return $output;
		}

		if(isset($this->_data[$index]) && $this->_data[$index]) {
			return addslashes($this->_data[$index]);
		} else {
			return false;
		}
	}

	public function add($file = null)
	{	
		$instance = & get_instance();
		$instance->load->helper('databases_filter');
		$instance->load->helper('set_source');
		$image = null;

		if(!empty($this->width) && !empty($this->height)) $image = get_image($this->width, $this->height, "{$this->file_path}");
		if($image) $this->_data[$file] = addslashes(json_encode(array("{$this->file_path}/".json_decode($image, TRUE)[0],json_decode($image, TRUE)[1])));

		$dfdb = databases_filter::build();
		$cols = array($this->table);

		$dfdb->set_query($cols, $this->_data)
		     ->filter_blank($cols)
			 ->insert_complete($cols);

		return $cols;
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
		$cols = array($this->table);

		$dfdb->set_query($cols, $this->_data)
		     ->filter_blank($cols)
			 ->update_complete($cols, array($this->table=>array('id'=>$this->id)));

		return $cols;
		
	}
}