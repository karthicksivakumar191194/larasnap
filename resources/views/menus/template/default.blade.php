@if(!isset($innerLoop))
   <ul class="menus main" id="accordionSidebar">
       @php
           $i = 1; //main menu - initialize loop value
           $j = 0; //sub-menu - initialize loop value
       @endphp
@else
    <ul class="navbar-nav sub-menu">
@endif

    <!-- iterate every menu-item main/sub-menu -->
    @foreach ($items as $item)

        @php
            $originalItem   = $item;
            //iniatilize the variables for no-conflict
            $linkClass      = null;
            $linkAttributes = null;
            if(isset($item->icon) && !empty($item->icon)){
                $icon       = $item->icon;
            }else{
                $icon       = config('larasnap.menu.default_icon');
            }
             if(url($item->link()) == url()->current()){
                $listItemClass = 'active';
            }else{
                $listItemClass = '';
            }

            // With Children Attributes
            if(!$originalItem->children->isEmpty()) {
                $iteration      =  $i.$j;
                $target         = 'collapse'.$iteration;
                $target_parent  =  $iteration == 10 ? 'accordionSidebar' : $target; //represents 'li' element parent(ul) - immediate parent, wrapper element(div)
                $linkClass      = 'collapsed';
                $linkAttributes = 'data-toggle="collapse" data-target="#'.$target.'" aria-expanded="true" aria-controls="'.$target.'"';
            }
        @endphp

    <!-- menu-item-->
    <li class="nav-item {{$listItemClass}}">
        <a class="nav-link {{ $liClass ?? '' }}" href="{{ url($item->link()) }}" target="{{ $item->target }}" {!! $linkAttributes ?? '' !!}>
            <i class="fas fa-fw {{ $icon }}"></i>
            <span>{{ $item->title }}</span></a>

        <!-- if menu item has sub-menu-item call blade recursive -->
        @if(!$originalItem->children->isEmpty())
            @php $j++; @endphp
            <div id="{{ $target }}" class="collapse" data-parent="#{{ $target_parent  }}">
                <div class="bg-white py-2 collapse-inner rounded">
            <!-- recursive -->
            @include('larasnap::menus.template.default', ['items' => $originalItem->children, 'innerLoop' => true])
                <!-- recursive -->
                </div>
            </div>
        @endif
    <!-- if menu item has sub-menu-item call blade recursive -->

    </li>
    <!-- menu-item-->
    @php $i++; @endphp

    @endforeach
    <!-- iterate every menu-item main/sub-menu -->

</ul>