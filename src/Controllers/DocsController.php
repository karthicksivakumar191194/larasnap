<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocsController extends Controller{
    public function index(){
        return view('larasnap::docs.index');
    }

    public function icons(){
		return view('larasnap::docs.icons');
	}
}
