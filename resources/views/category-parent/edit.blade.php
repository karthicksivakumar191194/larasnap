@extends('larasnap::layouts.app', ['class' => 'category-parent-edit'])
@section('title','Category Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Parent Category</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <a href="{{ route('p_categories.index') }}" title="Back to Parent Category List" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back to Parent Category List
               </a> 
               <br> <br> 
               <form method="POST" action="{{ route('p_categories.update', $parentCategory->id) }}" class="form-horizontal" autocomplete="off">
			   @csrf
			   @method('PUT')
               <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="name" class="control-label">Name(Slug)<small class="text-danger required">*</small></label> 
                           <input name="name" type="text" id="name" class="form-control lower-case" value="{{ old('name', $parentCategory->name) }}">
                           @error('name')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="label" class="control-label">Label<small class="text-danger required">*</small></label> 
                           <input name="label" type="text" id="label" class="form-control" value="{{ old('label', $parentCategory->label) }}">
                           @error('label')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="label" class="control-label">Status<small class="text-danger required">*</small></label></br>
                            <select class="form-control" name="status">
                                <option value="1" {{ old('status', $parentCategory->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $parentCategory->status) == 0 ? 'selected' : '' }} >InActive</option>
                            </select>
                           @error('status')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
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