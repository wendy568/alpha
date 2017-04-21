<?php

class databases_filter{
    private $_instance;

	public static function build() {
        return new databases_filter();
    }

    function __construct()
    {
        $this->_instance = & get_instance();        
    }

    function set_query(&$cols, $datas)
    {
        $this->_instance->load->database();
        $cols = array_flip($cols);

        array_walk($cols, function (&$val, &$key){
            $val = $this->_instance->db->list_fields($key);
            $val = array_flip($val);
            foreach($val as &$v){
                $v = NULL;
            }
        });

        try{
            array_walk_recursive($cols, function (&$val, $key) use ($datas){
                if(@strlen($datas[$key]) > 0)
                {
                    $val = $datas[$key];
                }
            });
        }finally{
            unset($datas);
            return $this;
        }
    }

    function filter_blank(&$data)
    {
    	foreach ($data as $key => &$value) {
            foreach ($value as $k => &$v) {
                if(!strlen($value[$k]) > 0) {
                    unset($value[$k]);
                }
            }
            if (empty($data[$key])) {
                unset($data[$key]);
            }
    	}
        return $this;
    }

    function update_complete(&$data, $where)
    {
    	$result = '';
    	foreach($data as $key=>&$val) {
            foreach ($val as $k =>&$v) {
               $result .= '`'.$k.'`'.'='.'"'.$v.'"'.',';
            }
            $where[$key] = http_build_query($where[$key], '', ' and ');
            $data[$key] = "UPDATE {$key} SET ".substr($result, 0, -1)." WHERE {$where[$key]}";
            $result = '';
		}
    }

    function insert_complete(&$data)
    {
        $col = '';
        $value = '';
        array_walk($data, function (&$val, $key) use (&$data, $col, $value) {
            foreach($val as $k => $v) {
                $col .= "`{$k}`".',';
                $value .= '"'.$v.'"'.',';
            }
            $col = substr($col, 0, -1);
            $value = substr($value, 0, -1);
            $data[$key] ="INSERT {$key}({$col}) VALUES({$value})";
        });
    }
}