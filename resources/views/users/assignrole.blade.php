@extends('larasnap::layouts.app', ['class' => 'user-assignrole'])
@section('title','User Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Assign Roles to User({{ $user->full_name}})</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <a href="{{ route('users.index') }}" title="Back to Users List" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back to Users List
               </a> 
               <br> <br> 
               <form action="{{ route('users.assignrole_store', $user->id) }}" method="POST">
			      @csrf
                  @if($roles->isNotEmpty())
                  <div class="checkbox">
                     <label><input type="checkbox" id="bulk-checkall" > <strong>Check All Roles</strong></label>
                  </div>
                  @endif
                  @forelse($roles as $name => $id)
                  <div class="checkbox">
                     <label><input type="checkbox" @if(in_array($id, $user_roles)) checked @endif class="assign-check bulk-check" value="{{ $id }}" name="roles[]" data-msg="role per user"> {{ $name }}</label>
                  </div>
                  @empty
                  <p>No Roles</p>
                  @endforelse
				  @error('roles')
					<div>	
						<span class="text-danger">{{ $message }}</span>
					</div> 
				  @enderror 	  
                  @if($roles->isNotEmpty())
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
	var maximum_roles_selection = {{ config('larasnap.module_list.user.maximum_role_selection') }};
</script>	
@endsection