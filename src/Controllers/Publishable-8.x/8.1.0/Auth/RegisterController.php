<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use LaraSnap\LaravelAdmin\Models\UserProfile;
use LaraSnap\LaravelAdmin\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use LaraSnap\LaravelAdmin\Mail\NewUserAdminAlert;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 0,
        ]);
		
		/*
		$userProfile = new UserProfile;
        $userProfile->first_name = $data['f_name'];
        $userProfile->last_name = $data['l_name'];
        
        $user->userProfile()->save($userProfile);
		*/
		
		//Set default role as set in settings if registered from frontend.
		$settingsDefaultRole = setting('default_user_role');
		if(isset($settingsDefaultRole) && !empty($settingsDefaultRole) && $settingsDefaultRole != 0){
			$role = Role::where('id', $settingsDefaultRole)->first();
			if($role){
				$user->assignRole($role->id);
			}
		}
		
		$siteAdminEmail = setting('admin_email');
		if(isset($siteAdminEmail) && !empty($siteAdminEmail)){
			Mail::to($siteAdminEmail)->send(new NewUserAdminAlert($user->id));
		}
		
		return $user;
    }
}
