<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Requests\UserRequest;
use LaraSnap\LaravelAdmin\Services\UserService;
use LaraSnap\LaravelAdmin\Traits\Role;

class UserController extends Controller
{
	use Role;
	
	private $userService;
	private $userModel;

	 /**
     * Injecting UserService.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
		$this->userModel = config('larasnap.user_model_namespace');
    }
	
    /**
     * Display a listing of users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        setCurrentListPageURL('users');
        $filter_request = $this->userService->filterValue($request); //filter request
		$roles          = $this->getAllRoles();
		$users          = $this->userService->index($filter_request);

        return view('larasnap::users.index')->with(['users' => $users, 'roles' => $roles, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('larasnap::users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  UsertRequest $request	 
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {		
		$this->userService->store($request);
		
		return redirect()->route('users.index')->withSuccess('User successfully created.');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		/*try {
			$user = $this->userService->findOrFail($id);
		} catch (ModelNotFoundException $exception) {
			return redirect()->route('users.index')->withError($exception->getMessage());
		}*/
		try {
			$user = $this->userModel::findOrFail($id);
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('users.index')->withError('User not found by ID ' .$id);
		}
		return view('larasnap::users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		try {
			$user = $this->userModel::findOrFail($id);
            //If 'Super Admin Role' is added on the config & if the user has 'Super Admin Role', show the edit screen only if the logged in user has 'Super Admin Role'
            $superAdminRole = config('larasnap.superadmin_role');
            if(isset($superAdminRole) && !empty($superAdminRole) && $user->roles->contains('name', $superAdminRole) && !userHasRole($superAdminRole)){
                return redirect()->route('users.index')->withError('Illegal Access: No permission to edit user by ID ' .$id);
            }   
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('users.index')->withError('User not found by ID ' .$id);
		}
        return view('larasnap::users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  UserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->userModel::findOrFail($id);
            $this->userService->update($request, $id, $user);
            $listPageURL = getPreviousListPageURL('users') ?? route('users.index'); 

            return redirect($listPageURL)->withSuccess('User successfully updated.');
        }catch (ModelNotFoundException $exception) {
            return redirect()->route('users.index')->withError('User not found by ID ' .$id);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = $this->userModel::findOrFail($id);
            //If 'Super Admin Role' is added on the config & if the user has 'Super Admin Role', delete the user only if the logged in user has 'Super Admin Role'
            $superAdminRole = config('larasnap.superadmin_role');
            if(isset($superAdminRole) && !empty($superAdminRole) && $user->roles->contains('name', $superAdminRole) && !userHasRole($superAdminRole)){
                return redirect()->route('users.index')->withError('Illegal Access: No permission to delete user by ID ' .$id);
            } 
            $this->userService->destroy($id, $user);

            return redirect()->route('users.index')->withSuccess('User successfully deleted.');
        }catch (ModelNotFoundException $exception) {
            return redirect()->route('users.index')->withError('User not found by ID ' .$id);
        }
    }

    /**
     * Remove multiple user from storage.
     *
     */
    public function bulkdestroy(Request $request){
        $idsToDelete = $request->records;
        if (count($idsToDelete)>0) {
            $this->userService->bulkDelete($idsToDelete);
            return redirect()->route('users.index')->withSuccess('Selected Users successfully deleted.');
        }
    }
	
	/**
     * Show the form for assigning roles to the specified user.
     *
     */
    public function assignRoleCreate($id)
    {
		//get existing user - role id, role label.	
		try {
			$user = $this->userModel::with('roles:id,name,label')->findOrFail($id);
            //If 'Super Admin Role' is added on the config & if the user has 'Super Admin Role', show the assign role screen only if the logged in user has 'Super Admin Role'
            $superAdminRole = config('larasnap.superadmin_role'); 
            if(isset($superAdminRole) && !empty($superAdminRole) && $user->roles->contains('name', $superAdminRole) && !userHasRole($superAdminRole)){
                return redirect()->route('users.index')->withError('Illegal Access: No permission to assign role for user by ID ' .$id);
            } 
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('users.index')->withError('User not found by ID ' .$id);
		}
		
		$user_roles = [];
		foreach($user->roles as $role){
			$user_roles[] = $role->id;
		}
		$roles  = $this->getAllRoles();
		
        return view('larasnap::users.assignrole', compact('roles', 'user', 'user_roles'));
    }
	
	/**
     * Update the specified role to user in storage.
     *
     */
    public function assignRoleStore(Request $request, $id)
    { 
		//$this->validate($request,['roles' => 'required'], ['roles.required' => 'Please select atleast one role for user.']);
		
		$user = $this->userModel::find($id);
		//check if their is currently role mapped to user & delete current user roles
        if($user->roles) {
            $user->roles()->detach();
        }
		//add user roles
		if($request->roles){	
			foreach ($request->roles as $role) {
				$user->assignRole($role);	
			}	
		}	

        $listPageURL = getPreviousListPageURL('users') ?? route('users.index'); 
		return redirect( $listPageURL)->withSuccess('Roles assigned to user successfully.');
    }
}

/**
 *When using ->get() you cannot simply use any of the below:
if (empty($result)) { }
if (!$result) { }
if ($result) { }
 *
 * To determine if there are any results you can do any of the following:
if ($result->first()) { }
if (!$result->isEmpty()) { }
if ($result->count()) { }
if (count($result)) { }
 *
 * Checking existence of relation:
$model->relation()->exists(); // bool: true if there is at least one row
$model->relation()->count();
 */