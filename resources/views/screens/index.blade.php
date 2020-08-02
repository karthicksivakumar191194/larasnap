@extends('larasnap::layouts.app', ['class' => 'screen-index'])
@section('title','Screen Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Screens</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
				<form  method="POST" action="{{ route('screens.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                    @method('POST')
                    @csrf
			   <div class="col-md-2 pad-0">
                   @canAccess('screens.create')
               <a href="{{ route('screens.create') }}" title="Add New Screen" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Screen
               </a>
                   @endcanAccess
			   </div>
               <div class="col-md-2 pad-0">
                   @canAccess('modules.index')
               <a href="{{ route('modules.index') }}" title="Manage Modules" class="btn btn-primary btn-sm">Manage Modules
               </a>
                   @endcanAccess
			   </div>
				<!-- list filters -->
				<div class="col-md-8 filters">
					@include('larasnap::list-filters.screen')
				</div>	
				<!-- list filters -->
               <br> <br> 
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Name(Route Name)</th>
                           <th>Label</th>
                           <th>Module</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
					@forelse($screens as $screen)	
                        <tr>
                           <td>{{ $screen->id }}</td>
                           <td>{{ $screen->name }}</td>
                           <td>{{ $screen->label }}</td>
                           <td>{{ $screen->module ? $screen->module->label : '' }}</td>
                           <td>
                               @canAccess('screens.edit')
							  <a href="{{ route('screens.edit', $screen->id) }}" title="Edit Screen"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                               @endcanAccess
                               @canAccess('screens.assignrole_create')
							   <a href="{{ route('screens.assignrole_create', $screen->id) }}" title="Assign Role"><button class="btn btn-success btn-sm" type="button"><i aria-hidden="true" class="fa fa-key"></i></button></a>
                               @endcanAccess
                               @canAccess('screens.destroy')
                               <a href="#" onclick="return individualDelete({{ $screen->id }})" title="Delete Screen"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                               @endcanAccess
                           </td>
                        </tr>
						@empty
						<tr>
							<td class="text-center" colspan="12">No Screen found!</td>
						</tr>
						@endforelse

                     </tbody>
                  </table>
                  <div class="pagination">
					{{ $screens->links() }}
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