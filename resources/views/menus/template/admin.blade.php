<ol class="dd-list">
   @foreach ($items as $item)
   <li class="dd-item" data-id="{{ $item->id }}">
      <div class="pull-right item_actions">
         <form class="menu-item-destroy" action="{{ route('menus.item.destory', $item->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger pull-right delete" title="Delete Menu Item" onclick="return confirm('Are you sure, you want to delete the menu item?')"><i class="fa fa-trash"></i></button>
         </form>
         <div class="btn btn-sm btn-primary pull-right edit edit_item"
            data-id="{{ $item->id }}"
            data-title="{{ $item->title }}"
            data-icon="{{ $item->icon }}"
            data-target="{{ $item->target }}"
            data-url="{{ $item->url }}"
            data-route="{{ $item->route }}"
            data-parameter="{{ json_encode($item->route_parameter) }}"
            title="Edit Menu Item" >
            <i class="fa fa-pencil-square-o"></i>
         </div>
      </div>
      <div class="dd-handle">
         <span>{{ $item->title }}</span> <small class="url"></small>
      </div>
      @if(!$item->children->isEmpty())
      @include('larasnap::menus.template.admin', ['items' => $item->children])
      @endif
   </li>
   @endforeach
</ol>
@if($items->isEmpty())
   <p class="text-center">No menu-item assigned!</p>
@endif