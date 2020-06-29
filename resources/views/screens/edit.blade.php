@extends('larasnap::layouts.app', ['class' => 'screen-edit'])
@section('title','Screen Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Screen</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <a href="{{ route('screens.index') }}" title="Back to Screen List" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back to Screen List
               </a> 
               <br> <br> 
               <form method="POST" action="{{ route('screens.update', $screen->id) }}" class="form-horizontal" autocomplete="off">
			   @csrf
			   @method('PUT')
               <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="name" class="control-label">Name(Route Name)<small class="text-danger required">*</small></label> 
                           <input name="name" type="text" id="name" class="form-control lower-case" value="{{ old('name', $screen->name) }}">
                           @error('name')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="label" class="control-label">Label<small class="text-danger required">*</small></label> 
                           <input name="label" type="text" id="label" class="form-control" value="{{ old('label', $screen->label) }}">
                           @error('label')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                      <div class="col-md-6">
                        <div class="form-group">
                           <label for="module" class="control-label">Module<small class="text-danger required">*</small></label> 
                           <input type="text" name="module" id="module" class="form-control autocomplete autocomplete-value" value="{{ old('module', $screen->module ? $screen->module->label : '') }}" />  
                           <input type="hidden" name="module_id" class="autocomplete-id" value="{{ old('module_id', $screen->module ? $screen->module->id : '') }}" />  
                            <div id="autocompleteList"></div>  
                           <p class="add-module"> + Add New Module </p>
                           @error('module_id')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     </div>
                     <div id="add-module" class="row hide-add-module">
                        <div class="col-6">
                            <div class="form-group">
                            <input name="new_module" type="text" id="new-module" class="form-control" value="">  </div>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn" id="add-new-module">Add New Module</button> 
                        </div>
                    </div>
                   <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <input type="submit" value="Update" class="btn btn-primary">
                        </div>
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
@section('script')
   <script>
       var autocomplete_url = "{{ route('screens.modules') }}";
   </script>
@endsection