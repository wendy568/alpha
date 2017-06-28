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
        $s1 = floor(($pages * $page_nums_per) / $limit);
        $s1 = $s1 ? $s1 : 1;

        if ($pages * $page_nums_per > $limit * $s1) {

            $start = $s1 * $limit;
            $this->start = $s1 * $limit;
        } elseif ($pages * $page_nums_per = $limit * $s1) {

            $start = ($s1 - 1) * $limit;
            $this->start = ($s1 - 1) * $limit;
        } else {

            return false;
        }
    }

    protected function set_pages()
    {
        if (empty($this->_array)) return false;
        $result = [];
        $keys = range($this->start, $this->start + $this->total_nums - 1);
        $this->_array = array_combine($keys, $this->_array);
        $total_pages = ceil(($this->start + $this->total_nums) / $this->page_nums_per);

        // if ($total_pages == 0) $this->pages = 1;
        // if ($this->pages > $total_pages && $total_pages != 0) $this->pages = $total_pages;
        // if ($this->pages < 0) $this->pages = 1;
        
        for ($this->pages; $this->pages <= $total_pages; $this->pages++) {
            $offset = ($this->pages - 1) * $this->page_nums_per;
            $L = $offset + $this->page_nums_per;
            for ($offset; $offset < $L; $offset++) {
                if (!empty($this->_array[$offset])) $result["_{$this->pages}"]['list'][] = $this->_array[$offset];
            }
        }

        if (empty($result)) return false;

        $result['total_pages'] = $total_pages;
        $result['total_nums'] = $this->start + $this->total_nums;

        return $result;        
    }

}