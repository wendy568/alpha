<?php  

trait pagination
{
    protected $_array;
    protected $total_nums;
    protected $pages;
    protected $page_nums_per;

    public function set_array($array, $pages, $page_nums_per = 5)
    {
        $this->_array = $array;
        $this->total_nums = count($array);
        $this->page_nums_per = $page_nums_per;
        $this->pages = $pages ? $pages : 1;
        return $this;
    }

    protected function set_pages()
    {
        var_dump($this->page_nums_per);die;
    	$total_pages = ceil($this->total_nums / $this->page_nums_per);
    	$offset = ($this->pages - 1) * $this->page_nums_per;
        $result = array_slice($this->_array,$offset, $this->page_nums_per);
        print_r($result);
    	// $map = $this->_map." LIMIT {$offset},{$this->page_nums_per}";
    	// return array('pages' => $total_pages, 'data' => $this->_db->query($map)->result_array());
        
    }

}