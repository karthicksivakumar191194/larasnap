@extends('larasnap::layouts.app', ['class' => 'role-index'])
@section('title','Role Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Roles</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
				<form  method="POST" action="{{ route('roles.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                    @method('POST')
                    @csrf
			   <div class="col-md-2 pad-0">
                   @canAccess('roles.create')
                        <a href="{{ route('roles.create') }}" title="Add New User" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Role
                        </a>
                   @endcanAccess
			   </div>
				<!-- list filters -->
				<div class="col-md-10 filters">
					@include('larasnap::list-filters.role')
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
					@forelse($roles as $role)	
                        <tr>
                           <td>{{ $role->id }}</td>
                           <td>{{ $role->name }}</td>
                           <td>{{ $role->label }}</td>
                           <td>
						       @showData('role', $role->name)
                               @canAccess('roles.edit')
							  <a href="{{ route('roles.edit', $role->id) }}" title="Edit Role"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                               @endcanAccess
                               @canAccess('roles.assignpermission_create')
							  <a href="{{ route('roles.assignpermission_create', $role->id) }}" title="Assign Permissions"><button class="btn btn-success btn-sm" type="button"><i aria-hidden="true" class="fa fa-key"></i></button></a>
                               @endcanAccess
                               @canAccess('roles.assignscreen_create')
                               <a href="{{ route('roles.assignscreen_create', $role->id) }}" title="Assign Screens"><button class="btn btn-warning btn-sm" type="button"><i aria-hidden="true" class="fa fa-tv"></i></button></a>
                               @endcanAccess
                               @canAccess('roles.destroy')
                               <a href="#" onclick="return individualDelete({{ $role->id }})" title="Delete Role"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                               @endcanAccess
							   @endshowData
                           </td>
                        </tr>
						@empty
						<tr>
							<td class="text-center" colspan="12">No Role found!</td>
						</tr>
						@endforelse

                     </tbody>
                  </table>
                  <div class="pagination">
					{{ $roles->links() }}
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