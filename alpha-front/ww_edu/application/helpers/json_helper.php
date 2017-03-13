<?php 

function encode_json($response, $data, $status = 200, $cached = null, $paras = null, $server = 'localhost')
{
	header("Content-type: application/json");
	set_status_header($status);
	
	$array = array_merge($response,$data);
	if (is_object($cached)) {
		$cached->addServer($server, 11211);
		$cached->set($paras, toJson($array)); // Return 1
	}
	echo toJson($array);
}

function utf82utf16($utf8)
{
    if(function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($utf8, 'UTF-16', 'UTF-8');
    }
    switch(strlen($utf8)) {
        case 1:
            return $utf8;
        case 2:
            return chr(0x07 & (ord($utf8{0}) >> 2))
                 . chr((0xC0 & (ord($utf8{0}) << 6))
                     | (0x3F & ord($utf8{1})));
        case 3:
            return chr((0xF0 & (ord($utf8{0}) << 4))
                     | (0x0F & (ord($utf8{1}) >> 2)))
                 . chr((0xC0 & (ord($utf8{1}) << 6))
                     | (0x7F & ord($utf8{2})));
    }
    return '';
}

function utf162utf8($utf16)
{
    if(function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($utf16, 'UTF-8', 'UTF-16');
    }
    $bytes = (ord($utf16{0}) << 8) | ord($utf16{1});
    switch(true) {
        case ((0x7F & $bytes) == $bytes):
            return chr(0x7F & $bytes);
        case (0x07FF & $bytes) == $bytes:
            return chr(0xC0 | (($bytes >> 6) & 0x1F))
                 . chr(0x80 | ($bytes & 0x3F));
        case (0xFFFF & $bytes) == $bytes:
            return chr(0xE0 | (($bytes >> 12) & 0x0F))
                 . chr(0x80 | (($bytes >> 6) & 0x3F))
                 . chr(0x80 | ($bytes & 0x3F));
    }
    return '';
}

function toJson($var)
{
    switch (gettype($var)) {
        case 'boolean':
            return $var ? 'true' : 'false';
        case 'NULL':
            return 'null';
        case 'integer':
            return (int) $var;
        case 'double':
        case 'float':
            return (float) $var;
        case 'string':

            $ascii = '';
            $strlen_var = strlen($var);

            for ($c = 0; $c < $strlen_var; ++$c) {
                $ord_var_c = ord($var{$c});
                switch (true) {
                    case $ord_var_c == 0x08:
                        $ascii .= '\b';
                        break;
                    case $ord_var_c == 0x09:
                        $ascii .= '\t';
                        break;
                    case $ord_var_c == 0x0A:
                        $ascii .= '\n';
                        break;
                    case $ord_var_c == 0x0C:
                        $ascii .= '\f';
                        break;
                    case $ord_var_c == 0x0D:
                        $ascii .= '\r';
                        break;
                    case $ord_var_c == 0x22:
                    case $ord_var_c == 0x2F:
                    case $ord_var_c == 0x5C:

                        $ascii .= '\\'.$var{$c};
                        break;
                    case (($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):

                        $ascii .= $var{$c};
                        break;
                    case (($ord_var_c & 0xE0) == 0xC0):
                        $char = pack('C*', $ord_var_c, ord($var{$c + 1}));
                        $c += 1;
                        $utf16 = $this->utf82utf16($char);
                        $ascii .= sprintf('\u%04s', bin2hex($utf16));
                        break;
                    case (($ord_var_c & 0xF0) == 0xE0):
                        $char = pack('C*', $ord_var_c,
                                     ord($var{$c + 1}),
                                     ord($var{$c + 2}));
                        $c += 2;
                        $utf16 = $this->utf82utf16($char);
                        $ascii .= sprintf('\u%04s', bin2hex($utf16));
                        break;
                    case (($ord_var_c & 0xF8) == 0xF0):
                        $char = pack('C*', $ord_var_c,
                                     ord($var{$c + 1}),
                                     ord($var{$c + 2}),
                                     ord($var{$c + 3}));
                        $c += 3;
                        $utf16 = $this->utf82utf16($char);
                        $ascii .= sprintf('\u%04s', bin2hex($utf16));
                        break;
                    case (($ord_var_c & 0xFC) == 0xF8):
                        $char = pack('C*', $ord_var_c,
                                     ord($var{$c + 1}),
                                     ord($var{$c + 2}),
                                     ord($var{$c + 3}),
                                     ord($var{$c + 4}));
                        $c += 4;
                        $utf16 = $this->utf82utf16($char);
                        $ascii .= sprintf('\u%04s', bin2hex($utf16));
                        break;
                    case (($ord_var_c & 0xFE) == 0xFC):
                        $char = pack('C*', $ord_var_c,
                                     ord($var{$c + 1}),
                                     ord($var{$c + 2}),
                                     ord($var{$c + 3}),
                                     ord($var{$c + 4}),
                                     ord($var{$c + 5}));
                        $c += 5;
                        $utf16 = $this->utf82utf16($char);
                        $ascii .= sprintf('\u%04s', bin2hex($utf16));
                        break;
                }
            }
            return '"'.$ascii.'"';
        case 'array':

            if (is_array($var) && count($var) && (array_keys($var) !== range(0, sizeof($var) - 1))) {

                $properties = array_map('name_value',
                                        array_keys($var),
                                        array_values($var));
                return '{' . join(',', $properties) . '}';
            }

            $elements = array_map('toJson', $var);

            return '[' . join(',', $elements) . ']';

        default:
            return 'null';
    }
}