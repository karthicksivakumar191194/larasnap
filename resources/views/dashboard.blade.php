@extends('larasnap::layouts.app', ['class' => 'dashboard'])

@section('title','Dashboard')

@section('content')
<!-- Page Heading  Start-->
<div class="container">
   <div class="row admin">
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                    <h3> {{ $usersActiveCount }} </h3>
                    <h5> Active Users </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-red">
                <div class="inner">
                    <h3> {{ $usersInactiveCount }} </h3>
                    <h5> Inactive Users </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h3> {{ $rolesCount }} </h3>
                    <h5> Roles </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div class="card-box bg-orange">
                <div class="inner">
                    <h3> {{ $screensCount }} </h3>
                    <h5> Screens </h5>
                </div>
                <div class="icon">
                    <i class="fa fa-desktop"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Content End-->				  
@endsection
