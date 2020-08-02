<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller{
    public function noPermission(){
        setCurrentListPageURL('erros_401');
		return view('larasnap::layouts.errors.401');
	}
}
