<?php  

class constants{
	private $config = array(
			'alphatrader' => array()
		);

	public static function build() {
        return new constants();
    }

	public function __get($name){
        if(isset($this->config[$name])) {
            return $this->config[$name];
        }
        return null;
    }

    public function __set($name,$value){
        if(isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    public function __isset($name){
        return isset($this->config[$name]);
    }

    public function __construct()
    {
    	$this->alphatrader = parse_ini_file(INI.'alphatrader.ini', TRUE);
    }
}