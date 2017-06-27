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
    //总共 43
    //每页 5
    //页数9
    public function set_limit($pages, &$start, $limit, $page_nums_per)
    {
        if ($pages * $page_nums_per > $limit) {
            $multiplying = ceil(($pages * $page_nums_per) / $limit);
            var_dump($multiplying);
            $start += $multiplying * $limit + 1;
        }
    }

    protected function set_pages()
    {
    	$total_pages = ceil($this->total_nums / $this->page_nums_per);

        if ($total_pages == 0) $this->pages = 1;
        if ($this->pages > $total_pages && $total_pages != 0) $this->pages = $total_pages;
        if ($this->pages < 0) $this->pages = 1;

        for ($this->pages; $this->pages <= $total_pages; $this->pages++) {
            $offset = ($this->pages - 1) * $this->page_nums_per;
            $result["_{$this->pages}"] = array_slice($this->_array,$offset, $this->page_nums_per);
        }

        $result['total_pages'] = $total_pages;
        $result['total_nums'] = $this->total_nums;

        return $result;        
    }

}