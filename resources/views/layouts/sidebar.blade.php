<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" >
   <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
      <div class="sidebar-brand-text mx-3">
         @if(setting('site_logo'))
            <img class="logo sidebar-logo" src="{{ storageUrl(config('larasnap.uploads.site_settings.path')) .'/'. setting('site_logo') }}" alt="logo" style="width:125px;">
         @else
            {{ setting('site_name') }}
         @endif
      </div>
   </a>
   <!-- Divider -->
   <hr class="sidebar-divider my-0">
   <!-- SideBar Menu -->
   {!! menu(config('larasnap.menu.default_sidebar_menu')) !!}
   <!-- SideBar Menu -->
   <!-- Sidebar Toggler (Sidebar) -->
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>
</ul>
