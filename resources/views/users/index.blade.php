@extends('larasnap::layouts.app', ['class' => 'user-index'])
@section('title','User Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Users</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <form  method="POST" action="{{ route('users.index') }}" id="list-form" class="form-inline my-2 my-lg-0" autocomplete="off">
                  @method('POST')
                  @csrf
                  <div class="col-md-2 pad-0">
                     @canAccess('users.create')
                     <a href="{{ route('users.create') }}" title="Add New User" class="btn btn-primary btn-sm"><i aria-hidden="true" class="fa fa-plus"></i> Add New User
                     </a>
                     @endcanAccess
                  </div>
                  <!-- list filters -->
                  <div class="col-md-10 filters">
                     @include('larasnap::list-filters.user')
                  </div>
                  <!-- list filters -->
                  <br> <br> 
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th><input type="checkbox" id="bulk-checkall"></th>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Status</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                           @php
                              $superAdminRole = config('larasnap.superadmin_role');
                           @endphp
                           @forelse($users as $i => $user)
                           <tr>
                              @if(isset($superAdminRole) && !empty($superAdminRole) && $user->roles->contains('name', $superAdminRole) && !userHasRole($superAdminRole)) 
                                  <td><input type="checkbox" class="checkbox" name="records[]" value="" disabled></td>
                              @else
                                <td><input type="checkbox" class="checkbox bulk-check" name="records[]" value="{{ $user->id }}" data-id="{{$user->id}}"></td>
                              @endif
                              <td>{{ $user->id }}</td>
                              <td>{{ $user->full_name }}</td>
                              <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                              <td>
                                 @forelse($user->roles as $role)
                                 <span class="badge badge-success badge-role">{{ $role->label }}</span>
                                 @empty
                                 <span class="badge badge-danger">No Role</span>									
                                 @endforelse
                              </td>
                              <td>{{ $user->status_info }}</td>
                              <td>
                                 @canAccess('users.show')
                                 <a href="{{ route('users.show', $user->id) }}" title="View User"><button class="btn btn-info btn-sm" type="button"><i aria-hidden="true" class="fa fa-eye"></i></button></a>
                                 @endcanAccess
                                 <!-- If 'Super Admin Role' is added on the config & if the user has 'Super Admin Role', show the edit/assign role/delete options only if the logged in user has 'Super Admin Role' -->
                                 @if(isset($superAdminRole) && !empty($superAdminRole))
                                     @if($user->roles->contains('name', $superAdminRole) && !userHasRole($superAdminRole)) 
                                         @continue;
                                     @endif    
                                 @endif    
                                 @canAccess('users.edit')
                                     <a href="{{ route('users.edit', $user->id) }}" title="Edit User"><button class="btn btn-primary btn-sm" type="button"><i aria-hidden="true" class="fa fa-pencil-square-o"></i></button></a>
                                 @endcanAccess
                                 @canAccess('users.assignrole_create')
                                     <a href="{{ route('users.assignrole_create', $user->id)}}" title="Assign Role"><button class="btn btn-success btn-sm" type="button"><i aria-hidden="true" class="fa fa-key"></i></button></a>
                                 @endcanAccess
                                 @canAccess('users.destroy')
                                     <a href="#" onclick="return individualDelete({{ $user->id }})" title="Delete User"><button class="btn btn-danger btn-sm" type="button"><i aria-hidden="true" class="fa fa-trash"></i></button></a>
                                 @endcanAccess
                              </td>
                           </tr>
                           @empty
                           <tr>
                              <td class="text-center" colspan="12">No User found!</td>
                           </tr>
                           @endforelse
                        </tbody>
                     </table>
                     <div class="pagination">
                        {{ $users->links() }}
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