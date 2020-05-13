@extends('larasnap::layouts.app', ['class' => 'user-show'])
@section('title','User Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">User Details</h1>
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
			   <div class="row">
              <div class="col-md-8">
			  <strong class="table-heading">USER INFORMATION</strong>
			  <table class="details mb-10">
			  <tr><td>First Name</td><td>{{ $user->userProfile ? $user->userProfile->first_name : '- NA -' }}</td></tr>
			  <tr><td>Last Name</td><td>{{ $user->userProfile ? $user->userProfile->last_name : '- NA -' }}</td></tr>
			  <tr><td>Email Address</td><td>{{ $user->email }}</td></tr>
			  <tr><td>Mobile No</td><td>{{ $user->userProfile ? $user->userProfile->mobile_no : '- NA -' }}</td></tr>
			  </table>
			  <strong class="table-heading">ADDRESS INFORMATION</strong>
			  <table class="details mb-10">
			  <tr><td>Address</td><td>{{ $user->userProfile ? $user->userProfile->address : '- NA -' }}</td></tr>
			  <tr><td>State</td><td>{{ $user->userProfile ? $user->userProfile->state : '- NA -' }}</td></tr>
			  <tr><td>City</td><td>{{ $user->userProfile ? $user->userProfile->city : '- NA -' }}</td></tr>
			  <tr><td>Zip Code</td><td>{{ $user->userProfile ? $user->userProfile->pincode : '- NA -' }}</td></tr>
			  </table>
			  <table class="details">
			  <tr><td><strong>STATUS</strong></td><td>{{ $user->status_info }}</td></tr>
			  </table>
			  </div>
              <div class="col-md-4 text-center">
				<img src="{{ $user->avatar }}" class="rounded-circle user-photo" alt="Prof Picture" >
			  </div>
            </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Page Content End-->				  
@endsection