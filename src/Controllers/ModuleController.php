<?php

namespace LaraSnap\LaravelAdmin\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Session;
use LaraSnap\LaravelAdmin\Requests\ModuleRequest;
use LaraSnap\LaravelAdmin\Services\ModuleService;
use LaraSnap\LaravelAdmin\Models\Module;

class ModuleController extends Controller
{
	private $moduleService;

	/**
	* Injecting ModuleService.
	*/
    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }
	
    /**
     * Display a listing of the modules.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_request = $this->moduleService->filterValue($request); //filter request
        $modules = $this->moduleService->index($filter_request);

        return view('larasnap::modules.index')->with(['modules' => $modules, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new module.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created module in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModuleRequest $request)
    {
        $this->moduleService->store($request);
        
        Session::flash('success', 'Module successfully created.');
		return response()->json(['success'=>'Module successfully created.']);
    }

    /**
     * Display the specified module.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified module.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified module in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModuleRequest $request, $id)
    { 
        $this->moduleService->update($request, $id);
        
		Session::flash('success', 'Module successfully updated.');
    }

    /**
     * Remove the specified module from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->moduleService->destroy($id);

        return redirect()->route('modules.index')->withSuccess('Module successfully deleted.');
    }
	
    

}
