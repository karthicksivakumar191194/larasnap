<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaraSnap\LaravelAdmin\Requests\UserRequest;
use LaraSnap\LaravelAdmin\Services\UserService;
use App\User;
use Auth;

class ProfileController extends Controller
{
    private $userService;

	/**
     * Injecting UserService.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user(); 

        return view('larasnap::profile', compact('user'));
    }
    
    /**
     * Update the user in storage.
     *
     * @param  UserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
       $user = User::find($id);
       $this->userService->update($request, $id, $user, 'profile');

       return redirect()->route('profile.edit')->withSuccess('Profile successfully updated.');
    }
}
