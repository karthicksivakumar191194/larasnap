<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Requests\RoleRequest;
use LaraSnap\LaravelAdmin\Services\RoleService;
use LaraSnap\LaravelAdmin\Models\Role;
use LaraSnap\LaravelAdmin\Models\Permission;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Models\Module;

class RoleController extends Controller
{
	private $roleService;

	/**
	* Injecting RoleService.
	*/
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
	
    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        setCurrentListPageURL('roles');
        $filter_request = $this->roleService->filterValue($request); //filter request
	    $roles = $this->roleService->index($filter_request);
	   	   
        //return view('larasnap::roles.index', compact('roles', 'filter_request'));
        return view('larasnap::roles.index')->with(['roles' => $roles, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('larasnap::roles.create');
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $this->roleService->store($request);
		
		return redirect()->route('roles.index')->withSuccess('Role successfully created.');
    }

    /**
     * Display the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		try {
			$role = Role::findOrFail($id);
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('roles.index')->withError('Role not found by ID ' .$id);
		}
        return view('larasnap::roles.edit', compact('role'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $this->roleService->update($request, $id);
        $listPageURL = getPreviousListPageURL('roles') ?? route('roles.index');
		
		return redirect($listPageURL)->withSuccess('Role successfully updated.');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->roleService->destroy($id);

        return redirect()->route('roles.index')->withSuccess('Role successfully deleted.');
    }
			
	/**
     * Show the form for assigning permission to the specified role.
     *
     */
    public function assignPermissionCreate($id)
    {
		try {
			$role = Role::findOrFail($id);
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('roles.index')->withError('Role not found by ID ' .$id);
		}

		$role_permissions = [];
		foreach ($role->permissions as $permission){
		    $role_permissions[] = $permission->id;
        }
		
		$permissions = Permission::select('id', 'name', 'label')->get();
        $permissions = $permissions->pluck('id', 'label');
		
        return view('larasnap::roles.assignpermission', compact('permissions', 'role', 'role_permissions'));
    }
	
	/**
     * Update the specified permission to role in storage.
     *
     */
    public function assignPermissionStore(Request $request, $id)
    {
        $role = Role::find($id);
        //check if their is currently permission mapped to the role & delete current role permissions
        if($role->permissions) {
            $role->permissions()->detach();
        }
        if($request->permissions){
            foreach ($request->permissions as $permission){
                $role->assignPermission($permission);
            }
        }

        return redirect()->route('roles.index')->withSuccess('Permissions assigned to role successfully.');
    }

    /**
     * Show the form for assigning screen to the specified role.
     *
     */
    public function assignScreenCreate($id)
    {
        try {
            $role = Role::findOrFail($id);
        }catch (ModelNotFoundException $exception) {
            return redirect()->route('roles.index')->withError('Role not found by ID ' .$id);
        }

        $role_screens = [];
        foreach ($role->screens as $screen){
            $role_screens[] = $screen->id;
        }

        /*$screens = Screen::select('id', 'name', 'label')->get();
        $screens = $screens->pluck('id', 'label');*/

        $modules = Module::withCount('screens')->with('screens')->has('screens')->get(); 
        
        return view('larasnap::roles.assignscreen', compact('modules', 'role', 'role_screens'));

    }

    /**
     * Update the specified screen to role in storage.
     *
     */
    public function assignScreenStore(Request $request, $id)
    {
        $role = Role::find($id);
        //check if their is currently permission mapped to the role & delete current role permissions
        if($role->screens) {
            $role->screens()->detach();
        }
        if($request->screens){
            foreach ($request->screens as $screen){
                $role->assignScreen($screen);
            }
        }

        return redirect()->route('roles.index')->withSuccess('Screens assigned to role successfully.');
    }

}


/*
 * Gates and Policies restrict the users based on their logic.
 * Gates -
 *    Gates are Closures that determine if a user is authorized to perform a given action and are typically defined in the class App\Providers\AuthServiceProvider using the facade  Gate.
 *    Gates always receive a user instance as their first argument, and may optionally receive additional arguments such as a relevant Eloquent model.
 *    Working -
      app  >>  providers  >>  AuthServiceProvider.php file and define the gate -
            Gate::define('admin-only', function ($user) {
               if($user->isAdmin == 1){
                    return true;
                }
                return false;
             });
      Controller file -
           use Illuminate\Support\Facades\Gate;
           public function private(){
                 if (Gate::allows('admin-only', auth()->user())) {
                    return view('private');
                 }
                 return 'You are not admin!!!!';
            }
      If we need to use in view -
           @can('admin-only', auth()->user())
                <a href="{{ url('/private') }}">Private</a>
           @endcan

https://itnext.io/laravel-you-can-declare-your-gates-and-policies-in-your-controller-2b596f3dd373
https://www.larashout.com/laravel-policies-controlling-authorization-in-laravel

https://laravel-news.com/authorization-gates
 */