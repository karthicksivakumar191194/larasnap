<?php

namespace LaraSnap\LaravelAdmin\Services;

use LaraSnap\LaravelAdmin\Models\Category;
use LaraSnap\LaravelAdmin\Filters\CategoryParentFilters;
use LaraSnap\LaravelAdmin\Filters\CategoryFilters;

class CategoryService{

    /**
     * Injecting CategoryParentFilters & CategoryFilters.
     */
    public function __construct(CategoryParentFilters $parentCategoryFilters, CategoryFilters $categoryFilters)
    {
        $this->parentCategoryFilters = $parentCategoryFilters;
        $this->categoryFilters = $categoryFilters;
    }

	public function index($filter_request, $type, $parentCategoryID = null){
		$entriesPerPage = setting('entries_per_page');
        if($type === 'p_category'){
            $categories = Category::where('is_parent', '=', 1)->filter($this->parentCategoryFilters, $filter_request)->select('id', 'name', 'label', 'parent_category_id', 'status')->orderBy('id', 'DESC')->paginate($entriesPerPage);
        }elseif($type === 'category'){
            $categories = Category::where('parent_category_id', '=', $parentCategoryID)->filter($this->categoryFilters, $filter_request)->select('id', 'name', 'label', 'is_parent', 'parent_category_id', 'position', 'status' )->orderBy('position', 'ASC')->paginate($entriesPerPage); 
        }    
        //Not added else condition here to throw code exception error on typo issues.
		return $categories;
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
            session(['category_' . $filter_type => $data]);
        }elseif($request->has($filter_type) && $request->{$filter_type} == '' ){
            session(['category_' . $filter_type => '']);
            $data = $filters[$filter_type];
        }elseif(session('category_'.$filter_type)){
            $data = session('category_'.$filter_type);
        }else{
            $data = $filters[$filter_type];
        }

        return $data;
    }

    public function deleteFilterSessionData($request, $filter_key){
        $request->session()->forget('category_'.$filter_key);
    }

	public function store($request, $type, $parentCategoryID = null){
		$category = new Category;
		$category->name  = $request->name;
		$category->label = $request->label;
        
        if($type === 'category'){
            $category->is_parent = $request->is_parent;
            $category->position = $request->position;
            $category->parent_category_id = $parentCategoryID;
        }
        
		$category->save();
		
		return $category;
	}

	public function update($request, $id, $type){
		$category = Category::find($id);
		$category->name   = $request->name;
		$category->label  = $request->label;
        $category->status = $request->status;
        
        if($type === 'category'){
            $category->is_parent = $request->is_parent;
            $updateOtherCategories = $this->updateCategoryPosition($id, $request->position, $category);
            if($updateOtherCategories){
                $category->position = $request->position;
            }
        }
        
		$category->save();
		
		return $category;
	}
    
    public function updateCategoryPosition($categoryID, $newPosition, $categoryInstance){
        $currentPosition = $categoryInstance->position;
        if($currentPosition == $newPosition){ return false; }
        
        if($newPosition > $currentPosition){
            return Category::where([['position',  '>', $currentPosition], ['position', '<=', $newPosition]])->decrement('position' , 1);
        }else{
           return Category::where([['position',  '>=', $newPosition], ['position', '<', $currentPosition]])->increment('position' , 1);
        }
        
    }
	
	public function destroy($id, $type){
        $category = Category::find($id);
        $categoryPosition = $category->position;
        
        $category->delete();
        
        if($type === 'category'){
            $category = Category::where('position', '>', $categoryPosition)->decrement('position', 1);
        }
		
		return $category;
	}

}