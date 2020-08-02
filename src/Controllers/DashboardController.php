<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaraSnap\LaravelAdmin\Models\User;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Models\Screen;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        setCurrentListPageURL('dashboard');
        $usersActiveCount   = User::where('status', 1)->count();
        $usersInactiveCount = User::where('status', 0)->count();
        $rolesCount         = Role::count();
        $screensCount       = Screen::count();
        
		return view('larasnap::dashboard')->with(['usersActiveCount' => $usersActiveCount, 'usersInactiveCount' => $usersInactiveCount, 'rolesCount' => $rolesCount, 'screensCount' => $screensCount]);
    }
}
