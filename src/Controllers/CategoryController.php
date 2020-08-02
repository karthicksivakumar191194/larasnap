<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Requests\CategoryRequest;
use LaraSnap\LaravelAdmin\Services\CategoryService;
use LaraSnap\LaravelAdmin\Models\Category;

class CategoryController extends Controller
{
	private $categoryService;

	/**
	* Injecting CategoryService.
	*/
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
	
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $parentCategoryID)
    {
        $parentCategory = Category::where([['id', '=', $parentCategoryID], ['is_parent', '=', 1], ['status', '=', 1]])->first();
        if(!$parentCategory){
            return redirect()->route('p_categories.index')->withError('Parent Category not found by ID ' .$parentCategoryID);
        }
        $parentCategoryLabel = $parentCategory->label;
        
        setCurrentListPageURL('categories');
        $filter_request = $this->categoryService->filterValue($request); //filter request
        $categories = $this->categoryService->index($filter_request, 'category', $parentCategoryID); 

        return view('larasnap::category.index')->with(['parentCategoryID' => $parentCategoryID, 'parentCategoryLabel' => $parentCategoryLabel, 'categories' => $categories, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parentCategoryID = null)
    {
        if(!isset($parentCategoryID)){
            $parentCategoryID = request()->segment(3);
        }
        $parentCategory = Category::where([['id', '=', $parentCategoryID], ['is_parent', '=', 1], ['status', '=', 1]])->withCount('childCategory')->first();
        if(!$parentCategory){
            return redirect()->route('p_categories.index')->withError('Parent Category not found by ID ' .$parentCategoryID);
        }
        $parentCategoryLabel = $parentCategory->label;
        $childCategoryCount  = $parentCategory->child_category_count;
        $categoryPosition    = $childCategoryCount + 1;
        
        return view('larasnap::category.create')->with(['parentCategoryID' => $parentCategoryID, 'parentCategoryLabel' => $parentCategoryLabel, 'categoryPosition' => $categoryPosition]);
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request, $parentCategoryID)
    {
        $this->categoryService->store($request, 'category', $parentCategoryID);
		
		return redirect()->route('categories.index', $parentCategoryID)->withSuccess('Category successfully created.');
    }

    /**
     * Display the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($parentCategoryID = null, $id)
    { 
        if(!isset($parentCategoryID)){
            $parentCategoryID = request()->segment(3);
        }
		try {
			$category = Category::with('parentCategory')->findOrFail($id); 
		}catch (ModelNotFoundException $exception) {
			return redirect()->route('categories.index', $parentCategoryID)->withError('Category not found by ID ' .$id);
		}
        $parentCategoryLabel = $category->parentCategory ? $category->parentCategory->label : '';
        return view('larasnap::category.edit', compact('parentCategoryID', 'parentCategoryLabel', 'category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $parentCategoryID, $id)
    {
        $this->categoryService->update($request, $id, 'category');
		$listPageURL = getPreviousListPageURL('categories') ?? route('categories.index', $parentCategoryID); 
        
		return redirect($listPageURL)->withSuccess('Category successfully updated.');
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($parentCategoryID = null, $id)
    {
        if(!isset($parentCategoryID)){
            $parentCategoryID = request()->segment(3);
        }
        $this->categoryService->destroy($id, 'category');
		
		return redirect()->route('categories.index', $parentCategoryID)->withSuccess('Category successfully deleted.');
    }
}
