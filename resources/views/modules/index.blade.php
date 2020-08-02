@extends('larasnap::layouts.app', ['class' => 'module-index'])
@section('title','Module Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Modules</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-md-8">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
				<form  method="POST" action="{{ route('modules.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                    @method('POST')
                    @csrf
			   <div class="col-md-3 pad-0">
                    @canAccess('modules.create')
                        <a href="#" title="Add New Module" class="btn btn-primary btn-sm module-add"><i aria-hidden="true" class="fa fa-plus"></i> Add New Module
                        </a>
                   @endcanAccess
			   </div>
				<!-- list filters -->
				<div class="col-md-9 filters">
					@include('larasnap::list-filters.module')
				</div>	
				<!-- list filters -->
               <br> <br> 
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Label</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
					@forelse($modules as $module)	
                        <tr>
                           <td>{{ $module->id }}</td>
                           <td>{{ $module->label }}</td>
                           <td>
                               @canAccess('modules.edit')
							  <a href="#" title="Edit Module" data-id="{{ $module->id }}" data-label="{{ $module->label}}" class="module-edit"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                               @endcanAccess
                               @canAccess('modules.destroy')
                               <a href="#" onclick="return individualDelete({{ $module->id }})" title="Delete Module"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                               @endcanAccess
                           </td>
                        </tr>
						@empty
						<tr>
							<td class="text-center" colspan="12">No Module found!</td>
						</tr>
						@endforelse

                     </tbody>
                  </table>
                  <div class="pagination">
					{{ $modules->links() }}
				  </div>
               </div>
			   </form>
            </div>
            @canAccess('modules.destroy')
                <p>Deleting module doesn't delete all the screens mapped to them, instead will delete only the module & all screens mapped to the module will move to the no-module list.</p>
            @endcanAccess
         </div>
      </div>
   </div>
   <div class="col-md-4">
       @canAccess('modules.create')
       <div class="card shadow mb-4 module-add-form">
         <div class="card-body">
            <div class="card-body">
                  <h1 class="h3 text-gray-800 mb-10 module-form-title">Add Module</h1>
                  <form method="POST" action="{{ route('modules.store') }}"  class="form-horizontal" autocomplete="off">
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="label" class="control-label">Label<small class="text-danger required">*</small></label> 
                           <input name="label" type="text" id="module-label" class="form-control" value="">
                           @error('label')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <input type="submit" value="Save" id="module-submit" class="btn btn-primary">
                        </div>
                     </div>
                  </div>
                  </form>
            </div>
         </div>
        </div> 
        @endcanAccess
        @canAccess('modules.edit')
        <div class="card shadow mb-4 module-edit-form">
         <div class="card-body">
            <div class="card-body">
                  <h1 class="h3 text-gray-800 mb-10 module-form-title">Edit Module</h1>
                  <form method="POST" action="{{ route('modules.index') }}"  class="form-horizontal" autocomplete="off">
                  @csrf
                  @method('PUT')
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="label" class="control-label">Label<small class="text-danger required">*</small></label> 
                           <input name="label" type="text" id="module-edit-label" class="form-control" value="">
                           <input name="module_id" type="hidden" id="module-edit-id" value="">
                           @error('label')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <input type="submit" value="Update" id="module-update" class="btn btn-primary">
                        </div>
                     </div>
                  </div>
                  </form>
            </div>
         </div>
       </div>
       @endcanAccess
   </div>
</div>
<!-- Page Content End-->				  
@endsection