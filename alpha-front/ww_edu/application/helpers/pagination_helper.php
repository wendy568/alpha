<?php  

trait pagination
{
    protected $_array;
    protected $total_nums;
    protected $pages;
    protected $page_nums_per;
    protected $start = 0;

    public function set_array($array, $pages, $page_nums_per)
    {
        $this->_array = $array;
        $this->total_nums = count($array);
        $this->page_nums_per = $page_nums_per;
        $this->pages = $pages ? $pages : 1;
        return $this;
    }

    public function set_limit($pages, &$start, $limit, $page_nums_per)
    {
        if ($pages * $page_nums_per > $limit) {
            $multiplying = ceil(($pages * $page_nums_per) / $limit);
            $start += $multiplying * $limit + 1;
            $this->start = $multiplying * $limit;

            return true;
        } else {
            return false;
        }
    }

    protected function set_pages()
    {
        $keys = range(20, 40);
        print_r(count($keys));
        print_r($this->_array);
        print_r(array_combine($keys, $this->_array));die;
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