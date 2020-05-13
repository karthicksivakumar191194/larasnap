<?php

namespace LaraSnap\LaravelAdmin\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller{
    public function noPermission(){
		return view('larasnap::layouts.errors.401');
	}
}
