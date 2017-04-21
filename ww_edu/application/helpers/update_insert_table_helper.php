<?php
class interect
{
	public $inArray = array(
			'classes_online',
			'comment',
		);

	public static function build() {
        return new interect();
    }

	function intersectArray($array)
	{
		return array_intersect($this->inArray, $array);
	}
}