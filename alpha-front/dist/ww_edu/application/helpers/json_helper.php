<?php 

function encode_json($response, $data, $status = 200, $cached = null, $paras = null, $server = 'localhost')
{
	header("Content-type: application/chenqi+json");
	set_status_header($status);
	
	$array = array_merge($response,$data);
	if (is_object($cached)) {
		$cached->addServer($server, 11211);
		$cached->set($paras, json_encode($array)); // Return 1
	}
			
	echo json_encode($array);
}