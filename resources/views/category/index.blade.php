@extends('larasnap::layouts.app', ['class' => 'category-index'])
@section('title','Category Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Category Management - {{ $parentCategoryLabel }}</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
				<form  method="POST" action="{{ route('categories.index', $parentCategoryID) }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                    @method('POST')
                    @csrf
			   <div class="col-md-3 pad-0">
                   @canAccessCategory('categories.create')
               <a href="{{ route('categories.create', $parentCategoryID) }}" title="Add New Category" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New Category
               </a>
                   @endcanAccessCategory
			   </div>
				<!-- list filters -->
				<div class="col-md-9 filters">
					@include('larasnap::list-filters.category')
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
                           <th>Position</th>
                           <th>Status</th>
                           <th></th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                     @forelse($categories as $category)
                        <tr>
                           <td>{{ $category->id }}@if($category->is_parent == 1) <small class="parent-child-category">*</small> @endif</td>
                           <td>{{ $category->name }}</td>
                           <td>{{ $category->label }}</td>
                           <td>{{ $category->position }}</td>
                           <td>
                                @if($category->status === 1)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">InActive</span>
                                @endif
                           </td>
                           <td>
                                @if($category->is_parent == 1)
                                    @canAccessCategory('categories.index')
                                        <a href="{{ route('categories.index', $category->id) }}" title="Manage Categories"><button class="btn btn-primary btn-sm" type="button">Manage Categories</button></a>
                                    @endcanAccessCategory
                                @endif
                           </td>
                           <td>
                               @canAccessCategory('categories.edit')
							  <a href="{{ route('categories.edit', [ 'p_category' => $parentCategoryID, 'category' => $category->id ]) }}" title="Edit Category"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                               @endcanAccessCategory
                               @canAccessCategory('categories.destroy')
                              <a href="#" onclick="return individualDelete({{ $category->id }})" title="Delete Category"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                               @endcanAccessCategory
                           </td>
                        </tr>
                       @empty
						<tr>
							<td class="text-center" colspan="12">No Category found!</td>
						</tr>
                       @endforelse  

                     </tbody>
                  </table>
                  <div class="pagination">
						{{ $categories->links() }}
				  </div>
               </div>
			   </form>
                @if($categories->isNotEmpty())
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