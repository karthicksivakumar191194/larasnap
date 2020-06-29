@extends('larasnap::layouts.app', ['class' => 'category-edit'])
@section('title','Category Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Edit Category - {{ $parentCategoryLabel }}</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <a href="{{ route('categories.index', $parentCategoryID) }}" title="Back to Category List" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back to Category List
               </a> 
               <br> <br> 
               <form method="POST" action="{{ route('categories.update', [ 'p_category' => $parentCategoryID, 'category' => $category->id ]) }}" class="form-horizontal" autocomplete="off">
			   @csrf
			   @method('PUT')
               <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="name" class="control-label">Name(Slug)<small class="text-danger required">*</small></label> 
                           <input name="name" type="text" id="name" class="form-control lower-case" value="{{ old('name', $category->name) }}">
                           @error('name')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label for="label" class="control-label">Label<small class="text-danger required">*</small></label> 
                           <input name="label" type="text" id="label" class="form-control" value="{{ old('label', $category->label) }}">
                           @error('label')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="position" class="control-label">Position<small class="text-danger required">*</small></label>
                            <input name="position" type="number" id="position" class="form-control"  value="{{ old('position',  $category->position) }}">
                           @error('position')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="label" class="control-label">Status<small class="text-danger required">*</small></label></br>
                            <select class="form-control" name="status">
                                <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }} >InActive</option>
                            </select>
                           @error('status')
                           <span class="text-danger">{{ $message }}</span>
                           @enderror 							
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="label" class="control-label">Parent Category<small class="text-danger required">*</small></label></br>
                            <label class="radio-inline">
                                <input type="radio" name="is_parent" value="1" {{ old('is_parent', $category->is_parent) == 1 ? 'checked' : '' }}>Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="is_parent" value="0" {{ old('is_parent', $category->is_parent) == 0 ? 'checked' : '' }}>No
                            </label>
                            <br>
                            <small>(Selecting YES will provide you option for mapping other categories to this category.)</small><br>
                           @error('is_parent')
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