<?php  

trait date_format
{
	public function jsonDecode($data)
	{
		print_r($data);
		return json_decode($data, true);
	}
}