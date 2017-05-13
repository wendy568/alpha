<?php  

trait date_format
{
	public function jsonDecode($data)
	{
		return json_decode($data, true);
	}
}