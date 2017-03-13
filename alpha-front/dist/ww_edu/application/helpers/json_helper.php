<?php 

function encode_json($response, $data, $cached = null, $paras = null, $server = 'localhost')
{
	header("Content-type: application/json");
	http_response_code(201);
	
	$array = array_merge($response,$data);
	if (is_object($cached)) {
		$cached->addServer($server, 11211);
		$cached->set($paras, json_encode($array)); // Return 1
	}
			
	echo json_encode($array);
}