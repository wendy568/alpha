<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayController extends Controller
{
    public function index()
    {
    	echo json_encode(['response' => 'OK']);
    }
}
