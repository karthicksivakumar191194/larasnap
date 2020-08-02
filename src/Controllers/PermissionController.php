<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Requests\PermissionRequest;
use LaraSnap\LaravelAdmin\Services\PermissionService;
use LaraSnap\LaravelAdmin\Models\Permission;

class PermissionController extends Controller
{
	private $permissionService;

	/**
	* Injecting PermissionService.
	*/
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
	
    /**
     * Display a listing of the permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        setCurrentListPageURL('permissions');
        $filter_request = $this->permissionService->filterValue($request); //filter request
        $permissions = $this->permissionService->index($filter_request);

        return view('larasnap::permissions.index')->with(['permissions' => $permissions, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('larasnap::permissions.create');
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $this->permissionService->store($request);
		
		return redirect()->route('permissions.index')->withSuccess('Permission successfully created.');
    }

    /**
     * Display the specified permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		try {
			$permission = Permission::findOrFail($id);
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('permissions.index')->withError('Permission not found by ID ' .$id);
		}
        return view('larasnap::permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->permissionService->update($request, $id);
        $listPageURL = getPreviousListPageURL('permissions') ?? route('permissions.index'); 
		
		return redirect($listPageURL)->withSuccess('Permission successfully updated.');
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->permissionService->destroy($id);
		
		return redirect()->route('permissions.index')->withSuccess('Permission successfully deleted.');
    }
}
