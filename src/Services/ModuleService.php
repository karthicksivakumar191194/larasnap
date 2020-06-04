<?php

namespace LaraSnap\LaravelAdmin\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Models\Module;
use LaraSnap\LaravelAdmin\Filters\ModuleFilters;

class ModuleService{

    private $filters;

    /**
     * Injecting ModuleFilters.
     */
    public function __construct(ModuleFilters $filters)
    {
        $this->filters = $filters;
    }
	
	public function index($filter_request){
		$entriesPerPage = setting('entries_per_page');
        $modules = Module::filter($this->filters, $filter_request)->select('id', 'label')->orderBy('id', 'DESC')->paginate($entriesPerPage);

		return $modules;
	}

    // return filter request values
    public function filterValue($request){
        /*filter-array keys should be same as the filter-field name*/

        /*Declare filter variables*/
        $filters['search']      = null;

        /*If filter has values or if user accessing page via pagination, show filter values*/
        if($request->page || $request->search){
            foreach($filters as $filter_key => $filter_def_value) {
                $filters[$filter_key] = $this->filterValueData($request, $filters, $filter_key);
            }
        }else{
            //flush session values when accessing the page first time.
            foreach($filters as $filter_key => $filter_def_value) {
                $this->deleteFilterSessionData($request, $filter_key);
            }
        }

        return $filters;
    }

    /**
     * @param  request, filter default value, filter field name.
     **/
    public function filterValueData($request, $filters, $filter_type){
        //check if request is present and not null
        //check if request is present and null - used on 'search'
        //session has value
        //default value
        if($request->filled($filter_type)) {
            $data = $request->{$filter_type};
            session(['module_' . $filter_type => $data]);
        }elseif($request->has($filter_type) && $request->{$filter_type} == '' ){
            session(['module_' . $filter_type => '']);
            $data = $filters[$filter_type];
        }elseif(session('module_'.$filter_type)){
            $data = session('module_'.$filter_type);
        }else{
            $data = $filters[$filter_type];
        }

        return $data;
    }

    public function deleteFilterSessionData($request, $filter_key){
        $request->session()->forget('module_'.$filter_key);
    }

	public function store($request){
		$module = new Module;
		$module->label = $request->label;
		$module->save();
		
		return $module;
	}

	public function update($request, $id){
		$module = Module::find($id);
		$module->label = $request->label;
		$module->save();
		
		return $module;
	}

    public function destroy($id){
        $module = Module::destroy($id);

        return $module;
    }
}