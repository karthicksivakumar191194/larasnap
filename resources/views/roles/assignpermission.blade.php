@extends('larasnap::layouts.app', ['class' => 'rolemanagement-assignpermission'])
@section('title','Role Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Assign Permissions to Role({{ $role->label}})</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <a href="{{ route('roles.index') }}" title="Back to Roles List" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back to Roles List
               </a> 
               <br> <br> 
               <form action="{{ route('roles.assignpermission_store', $role->id) }}" method="POST">
			      @csrf
                  <div class="checkbox">
                    @if($permissions->isNotEmpty())
                        <label><input type="checkbox" id="bulk-checkall" > <strong>Check All Permissions</strong></label>
                    @endif
                  </div>
                  @forelse($permissions as $name => $id)
                  <div class="checkbox">
                     <label><input type="checkbox" @if(in_array($id, $role_permissions)) checked @endif class="assign-check bulk-check" value="{{ $id }}" name="permission[]" data-msg="permission per role"> {{ $name }}</label>
                  </div>
                  @empty
                  <p>No Permission</p>
                  @endforelse
                  @if($permissions->isNotEmpty())
                        <input type="submit" value="Update" class="btn btn-primary"> 
                  @endif
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
       var maximum_roles_selection = {{ config('larasnap.module_list.role.maximum_permission_selection') }};
   </script>
@endsection