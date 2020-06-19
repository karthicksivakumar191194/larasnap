<?php

namespace LaraSnap\LaravelAdmin\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Models\Screen;
use LaraSnap\LaravelAdmin\Filters\ScreenFilters;

class ScreenService{

    private $filters;

    /**
     * Injecting ScreenFilters.
     */
    public function __construct(ScreenFilters $filters)
    {
        $this->filters = $filters;
    }
	
	public function index($filter_request){
		$entriesPerPage = setting('entries_per_page');
        $screens = Screen::with('module:id,label')->filter($this->filters, $filter_request)->select('id', 'name', 'label', 'module_id')->orderBy('id', 'DESC')->paginate($entriesPerPage);

		return $screens;
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
            session(['screen_' . $filter_type => $data]);
        }elseif($request->has($filter_type) && $request->{$filter_type} == '' ){
            session(['screen_' . $filter_type => '']);
            $data = $filters[$filter_type];
        }elseif(session('screen_'.$filter_type)){
            $data = session('screen_'.$filter_type);
        }else{
            $data = $filters[$filter_type];
        }

        return $data;
    }

    public function deleteFilterSessionData($request, $filter_key){
        $request->session()->forget('screen_'.$filter_key);
    }

	public function store($request){
		$screen = new Screen;
		$screen->name = $request->name;
		$screen->label = $request->label;
		$screen->module_id = $request->module_id;
		$screen->save();
		
		return $screen;
	}

	public function update($request, $id){
		$screen = Screen::find($id);
		$screen->name = $request->name;
		$screen->label = $request->label;
        $screen->module_id = $request->module_id;
		$screen->save();
		
		return $screen;
	}

    public function destroy($id){
        $screen = Screen::destroy($id);

        return $screen;
    }
}