<?php  

class pagination{
	private $_pages = array(
            '_db' => '',
            'total_nums' => '',
            'pages' => '',
            'page_nums_per' => '',
            '_map' => '',
		);

	public static function build() {
        return new pagination();
    }

	public function __get($name){
        if(isset($this->_pages[$name])) {
            return $this->_pages[$name];
        }
        return null;
    }

    public function __set($name,$value){
        if(isset($this->_pages[$name])) {
            $this->_pages[$name] = $value;
        }
    }

    public function __isset($name){
        return isset($this->_pages[$name]);
    }

    public function set_pages()
    {
    	$this->_db->query($this->_map)->result_array();
    	$this->total_nums = $this->_db->affected_rows();
    	$total_pages = ceil($this->total_nums / $this->page_nums_per);
    	$offset = ($this->pages - 1) * $this->page_nums_per;
    	$map = $this->_map." LIMIT {$offset},{$this->page_nums_per}";
    	return array('pages' => $total_pages, 'data' => $this->_db->query($map)->result_array());
    }

}