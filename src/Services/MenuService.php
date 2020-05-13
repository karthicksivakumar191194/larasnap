<?php

namespace LaraSnap\LaravelAdmin\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Models\Menu;
use LaraSnap\LaravelAdmin\Filters\MenuFilters;

class MenuService{

    private $filters;

    /**
     * Injecting MenuFilters.
     */
    public function __construct(MenuFilters $filters)
    {
        $this->filters = $filters;
    }

    public function index($filter_request){
        $entriesPerPage = setting('entries_per_page');
        $menus = Menu::filter($this->filters, $filter_request)->select('id', 'name', 'label')->orderBy('id', 'DESC')->paginate($entriesPerPage);

        return $menus;
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
            session(['menu_' . $filter_type => $data]);
        }elseif($request->has($filter_type) && $request->{$filter_type} == '' ){
            session(['menu_' . $filter_type => '']);
            $data = $filters[$filter_type];
        }elseif(session('menu_'.$filter_type)){
            $data = session('menu_'.$filter_type);
        }else{
            $data = $filters[$filter_type];
        }

        return $data;
    }

    public function deleteFilterSessionData($request, $filter_key){
        $request->session()->forget('menu_'.$filter_key);
    }

    public function store($request){
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->label = $request->label;
        $menu->save();

        return $menu;
    }

    public function update($request, $id){
        $menu = Menu::find($id);
        $menu->name = $request->name;
        $menu->label = $request->label;
        $menu->save();

        return $menu;
    }

    public function destroy($id){
        $menu = Menu::destroy($id);

        return $menu;
    }
}