<?php

namespace LaraSnap\LaravelAdmin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LaraSnap\LaravelAdmin\Requests\MenuRequest;
use LaraSnap\LaravelAdmin\Services\MenuService;
use LaraSnap\LaravelAdmin\Models\Menu;
use LaraSnap\LaravelAdmin\Models\MenuItem;

class MenuController extends Controller
{
    private $menuService;

    /**
     * Injecting MenuService.
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Display a listing of the menus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        setCurrentListPageURL('menus');
        $filter_request = $this->menuService->filterValue($request); //filter request
        $menus = $this->menuService->index($filter_request);

        return view('larasnap::menus.index')->with(['menus' => $menus, 'filters' => $filter_request]);
    }

    /**
     * Show the form for creating a new menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('larasnap::menus.create');
    }

    /**
     * Store a newly created menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $this->menuService->store($request);

        return redirect()->route('menus.index')->withSuccess('Menu successfully created.');
    }

    /**
     * Display the specified menu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified menu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $menu = Menu::findOrFail($id);
        }catch (ModelNotFoundException $exception) {
            return redirect()->route('menus.index')->withError('Menu not found by ID ' .$id);
        }
		
		if(restrictData('menu', $menu->name)){
			return redirect()->route('menus.index')->withError('Illegal Access: No permission to edit menu by ID ' .$id);
		}
		
        return view('larasnap::menus.edit', compact('menu'));
    }

    /**
     * Update the specified menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, $id)
    {
        $this->menuService->update($request, $id);
        $listPageURL = getPreviousListPageURL('menus') ?? route('menus.index'); 

        return redirect($listPageURL)->withSuccess('Menu successfully updated.');
    }

    /**
     * Remove the specified menu from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
        }catch (ModelNotFoundException $exception) {
            return redirect()->route('menus.index')->withError('Menu not found by ID ' .$id);
        }
		
		if(restrictData('menu', $menu->name)){
			return redirect()->route('menus.index')->withError('Illegal Access: No permission to delete menu by ID ' .$id);
		}
		
        $this->menuService->destroy($id);

        return redirect()->route('menus.index')->withSuccess('Menu successfully deleted.');
    }

    /**
     * Display a listing of the menu items for the specified menu.
     */
    public function builder($id){
		$menu = Menu::findOrFail($id);
        return view('larasnap::menus.builder', compact('menu'));
    }

    /**
     * Store a newly created menu-item in storage.
     */
    public function itemStore(Request $request){
        $highestOrder = 1;
        $order = MenuItem::orderBy('order', 'Desc')->first();
        if(!is_null($order)){
            $highestOrder = $order->order + 1;
        }

        $menuItem = new MenuItem();
        $menuItem->menu_id          = $request->menu_id;
        $menuItem->title            = $request->title;
        $menuItem->icon             = $request->font_icon;
        $menuItem->parent_id        = NULL;
        $menuItem->order            = $highestOrder;
        $menuItem->target           = $request->target;
        $menuItem->url              = $request->url;
        $menuItem->route            = $request->route;
        $menuItem->route_parameter  = $request->parameters;
        $menuItem->save();

        return redirect()->route('menus.builder', $request->menu_id)->withSuccess('Menu Item successfully created.');
    }

    /**
     * Update the specified menu-item in storage.
     */
    public function itemUpdate(Request $request){
        $menuItem = MenuItem::findOrFail($request->menu_item_id);
        $menuItem->title            = $request->title;
        $menuItem->icon             = $request->font_icon;
        $menuItem->target           = $request->target;
        $menuItem->url              = $request->url;
        $menuItem->route            = $request->route;
        $menuItem->route_parameter  = $request->parameters;
        $menuItem->save();

        return redirect()->route('menus.builder', $request->menu_id)->withSuccess('Menu Item successfully updated.');
    }

    /**
     * Remove the specified menu-item from storage.
     */
    public function itemDestroy($id){
        $menuItem = MenuItem::findOrFail($id);
        $menuId   = $menuItem->menu_id;
        $menuItem->destroy($id);

        return redirect()->route('menus.builder', $menuId)->withSuccess('Menu Item successfully deleted.');
    }

    /**
     * Update the 'parent_id', 'order' of the menu item in storage when ordering(drag & drop) the menu item.
     */	
	public function orderItem(Request $request){
        $menuItemOrder = json_decode($request->input('order'));
        $this->orderMenu($menuItemOrder, null);
    }

    private function orderMenu(array $menuItems, $parentId){
	    foreach ($menuItems as $index => $menuItem){
	        //find menu item and update the order & parent Id
            $item = MenuItem::findOrFail($menuItem->id);
            $item->order = $index + 1;
            $item->parent_id = $parentId;
            $item->save();

            if (isset($menuItem->children)) {
                $this->orderMenu($menuItem->children, $item->id);
            }
        }
    }
}
