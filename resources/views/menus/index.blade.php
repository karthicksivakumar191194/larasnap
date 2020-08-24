@extends('larasnap::layouts.app', ['class' => 'menu-index'])
@section('title','Menu Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Menus</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <form  method="POST" action="{{ route('menus.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                  @method('POST')
                  @csrf
                  <div class="col-md-2 pad-0">
                     @canAccess('menus.create')
                     <a href="{{ route('menus.create') }}" title="Add New Menu" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Menu
                     </a>
                     @endcanAccess
                  </div>
                  <!-- list filters -->
                  <div class="col-md-10 filters">
                     @include('larasnap::list-filters.menu')
                  </div>
                  <!-- list filters -->
                  <br> <br> 
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th>ID</th>
                              <th>Name(Slug)</th>
                              <th>Label</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                        @forelse($menus as $menu)
                           <tr>
                              <td>{{ $menu->id }}</td>
                              <td>{{ $menu->name }}</td>
                              <td>{{ $menu->label }}</td>
                              <td>
                                 @canAccess('menus.builder')
                                 <a href="{{ route('menus.builder', $menu->id)}}" title="Menu Builder"><button class="btn btn-success btn-sm" type="button"><i aria-hidden="true" class="fa fa-list"></i></button></a>
                                 @endcanAccess
								 @showData('menu', $menu->name)
                                 @canAccess('menus.edit')
                                 <a href="{{ route('menus.edit', $menu->id) }}" title="Edit Menu"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                                 @endcanAccess
                                 @canAccess('menus.destroy')
                                 <a href="#" onclick="return individualDelete({{ $menu->id}})" title="Delete Menu"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                                 @endcanAccess
								 @endshowData
                              </td>
                           </tr>
                        @empty
                           <tr>
                              <td class="text-center" colspan="12">No Menu found!</td>
                           </tr>
                        @endforelse
                     </tbody>
                     </table>
                     <div class="pagination">
                        {{ $menus->links() }}
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Page Content End-->				  
@endsection