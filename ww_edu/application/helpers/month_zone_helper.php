<?php  

function time_splice($data, $_key = 'create_time')
{
	$_data = array();

	array_walk($data, function ($val, $key) use($_key, &$_data, $data) {
		if ($val[$_key]) {
			$_data = time_compare($val[$_key], $data[$key]);
		}
	});

	return $_data;
} 

function time_compare($date, $data)
{
	static $_data;

	$date_time = getdate(strtotime($date));
	//'_' 解决json无序性
	$_data[$date_time['year'] . '_'][$date_time['mon'] . '_'][$date_time['mday'] . '_'][] = $data;

	return $_data;
}

function sort_recursive(&$array)
{
	if(!is_array($array)) return false;

	foreach($array as $key => $value) {
		if(is_array($value)) {
			if(!is_numeric($key))
			ksort($array);
			sort_recursive($array[$key]);
		} else {
			return false;
		}
	}

	return $array;
}

function _fetch_from_array($array, $index = NULL)
{
	isset($index) OR $index = array_keys($array);
	// print_r($array);
	if (is_array($index))
	{
		$output = array();
		foreach ($index as $key)
		{
			$output[$key] = _fetch_from_array($array, $key);
		}

		return $output;
	}

	if (isset($array[$index]))
	{
		return $array[$index].'CQ';
	} else {
		return false;
	}

}
