@extends('larasnap::layouts.app', ['class' => 'permission-index'])
@section('title','Permission Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
				<form  method="POST" action="{{ route('permissions.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                    @method('POST')
                    @csrf
			   <div class="col-md-2 pad-0">
                   @canAccess('permissions.create')
               <a href="{{ route('permissions.create') }}" title="Add New Permission" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Permission
               </a>
                   @endcanAccess
			   </div>
				<!-- list filters -->
				<div class="col-md-10 filters">
					@include('larasnap::list-filters.permission')
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
					@forelse($permissions as $permission)	
                        <tr>
                           <td>{{ $permission->id }}</td>
                           <td>{{ $permission->name }}</td>
                           <td>{{ $permission->label }}</td>
                           <td>
                               @canAccess('permissions.edit')
							  <a href="{{ route('permissions.edit', $permission->id) }}" title="Edit Permission"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                               @endcanAccess
                               @canAccess('permissions.destroy')
                              <a href="#" onclick="return individualDelete({{ $permission->id }})" title="Delete Permission"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                               @endcanAccess
                           </td>
                        </tr>
						@empty
						<tr>
							<td class="text-center" colspan="12">No Permission found!</td>
						</tr>
						@endforelse

                     </tbody>
                  </table>
                  <div class="pagination">
						{{ $permissions->links() }}
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