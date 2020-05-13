<?php

namespace LaraSnap\LaravelAdmin\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Requests\ScreenRequest;
use LaraSnap\LaravelAdmin\Services\ScreenService;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Traits\Role;

class ScreenController extends Controller
{
	use Role;
	
	private $screenService;

	/**
	* Injecting ScreenService.
	*/
    public function __construct(ScreenService $screenService)
    {
        $this->screenService = $screenService;
    }
	
    /**
     * Display a listing of the screens.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_request = $this->screenService->filterValue($request); //filter request
        $screens = $this->screenService->index($filter_request);

        return view('larasnap::screens.index')->with(['screens' => $screens, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('larasnap::screens.create');
    }

    /**
     * Store a newly created screen in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScreenRequest $request)
    {
        $this->screenService->store($request);
		
		return redirect()->route('screens.index')->withSuccess('Screen successfully created.');
    }

    /**
     * Display the specified screen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified screen.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		try {
			$screen = Screen::findOrFail($id);
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('screens.index')->withError('Screen not found by ID ' .$id);
		}
       return view('larasnap::screens.edit',  compact('screen'));
    }

    /**
     * Update the specified screen in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScreenRequest $request, $id)
    {
        $this->screenService->update($request, $id);
		
		return redirect()->route('screens.index')->withSuccess('Screen successfully updated.');
    }

    /**
     * Remove the specified screen from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->screenService->destroy($id);

        return redirect()->route('screens.index')->withSuccess('Screen successfully deleted.');
    }
	
	 /**
     * Show the form for assigning roles to the specified screen.
     *
     */
    public function assignRoleCreate($id)
    {
		try {
			$screen = Screen::findOrFail($id);
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('screens.index')->withError('Screen not found by ID ' .$id);
		}

		$screen_roles = [];
		foreach ($screen->roles as $role){
		    $screen_roles[] = $role->id;
        }

		$roles = $this->getAllRoles();
		
        return view('larasnap::screens.assignrole', compact('roles', 'screen', 'screen_roles'));
    }
	
	/**
     * Update the specified role to screen in storage.
     *
     */
    public function assignRoleStore(Request $request, $id)
    {
      //print_r($request->roles);
      $screen = Screen::find($id);
      //check if their is currently role mapped to the screen & delete current role mapping
      if($screen->roles) {
          $screen->roles()->detach();
      }
      //add role mapping to screen
        if($request->roles){
            foreach ($request->roles as $role) {
                $screen->assignRole($role);
            }
        }

        return redirect()->route('screens.index')->withSuccess('Roles assigned to screen successfully.');
    }
}
