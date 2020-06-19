@extends('larasnap::layouts.app', ['class' => 'category-parent-index'])
@section('title','Category Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Category Management - Parent Category</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
				<form  method="POST" action="{{ route('p_categories.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                    @method('POST')
                    @csrf
			   <div class="col-md-3 pad-0">
                   @canAccess('p_categories.create')
               <a href="{{ route('p_categories.create') }}" title="Add New Parent Category" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Parent Category
               </a>
                   @endcanAccess
			   </div>
				<!-- list filters -->
				<div class="col-md-9 filters">
					@include('larasnap::list-filters.category-parent')
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
                           <th>Status</th>
                           <th></th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                     @forelse($parentCategories as $parentCategory)                       
                        <tr>
                           <td>{{ $parentCategory->id }}@isset($parentCategory->parent_category_id) <small class="parent-child-category">*</small> @endisset</td>
                           <td>{{ $parentCategory->name }}</td>
                           <td>{{ $parentCategory->label }}</td>
                           <td>
                                @if($parentCategory->status === 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">InActive</span>
                                @endif
                           </td>
                           <td>
                               @canAccess('categories.index')
                                    <a href="{{ route('categories.index', $parentCategory->id) }}" title="Manage Categories"><button class="btn btn-primary btn-sm" type="button">Manage Categories</button></a>
                                @endcanAccess
                           </td>
                           <td>
                               @canAccess('p_categories.edit')
                                    <a href="{{ route('p_categories.edit', $parentCategory->id) }}" title="Edit Parent Category"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                               @endcanAccess
                               @canAccess('p_categories.destroy')
                                    <a href="#" onclick="return individualDelete({{ $parentCategory->id }})" title="Delete Parent Category"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                               @endcanAccess
                           </td>
                        </tr>
                    @empty
						<tr>
							<td class="text-center" colspan="12">No Parent Category found!</td>
						</tr>
                    @endforelse

                     </tbody>
                  </table>
                  <div class="pagination">
						{{ $parentCategories->links() }}
				  </div>
               </div>
			   </form>
               @if($parentCategories->isNotEmpty())
                    <p class="mb-0"><b>NOTE</b></p>
                    <ul>
                       <li>The asterisk(*) symbol next to the ID represents, the category is both child & parent category.</li>
                       <li>Deleting a Parent Category will delete all its child-category & sub-child-category recursively.</li>         
                     </ul>
                @endif
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Page Content End-->				  
@endsection