@extends('larasnap::layouts.app', ['class' => 'document guide'])
@section('title','Guide')
@section('content')
    <!-- Page Heading  Start-->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Guide</h1>
    </div>
    <!-- Page Heading End-->
    <!-- Page Content Start-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseOne">
                                            <a class="card-title"> User Management</a>
                                        </div>
                                        <div id="collapseOne" class="card-body collapse" data-parent="#accordion">
                                            <strong>Module: </strong>User Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                            <li>Create User</li>
                                            <li>View User</li>
                                            <li>Edit User</li>
                                            <li>Delete User</li>
                                            <li>Assign Role to User</li>
                                                <ul class="sub-points">
                                                    <li>User can have multiple or single roles. </li>
                                                </ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion2" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseTwo">
                                            <a class="card-title"> Role Management</a>
                                        </div>
                                        <div id="collapseTwo" class="card-body collapse" data-parent="#accordion2">
                                            <strong>Module: </strong>Role Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Create Role</li>
                                                <li>Edit Role</li>
                                                <li>Delete Role</li>
                                                <li>Assign Permission to Role</li>
                                                <ul class="sub-points">
                                                    <li>Role can have multiple or single permission.</li>
                                                </ul>
                                                <li>Assign Screen to Role</li>
                                                <ul class="sub-points">
                                                    <li>Role can access multiple or single screen.</li>
                                                    <li>Screens are grouped based on the modules mapped.</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion3" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseThree">
                                            <a class="card-title"> Permission Management</a>
                                        </div>
                                        <div id="collapseThree" class="card-body collapse" data-parent="#accordion3">
                                            <strong>Module: </strong>Role Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Create Permission</li>
                                                <li>Edit Permission</li>
                                                <li>Delete Permission</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion4" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseFour">
                                            <a class="card-title"> Screen Management</a>
                                        </div>
                                        <div id="collapseFour" class="card-body collapse" data-parent="#accordion4">
                                            <strong>Module: </strong>Role Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Create Screen</li>
                                                <li>Edit Screen</li>
                                                <li>Delete Screen</li>
                                                <li>Assign Role to Screen</li>
                                                <ul class="sub-points">
                                                    <li>Screen can be accessed by multiple or single roles.</li>
                                                    <li>Based on the configuration set, this provide screen based restriction and also hides the button(button to navigate to the restricted page) from the list or other pages.</li>
                                                </ul>
                                            </ul>
                                            <p>Screen Name - Route Name(check routes/web.php file on the application)</p>
                                            <strong>User > Role > Screen relation</strong>
                                            <ul>
                                                <li>User Mapped to Role</li>
                                                <li>Role Mapped to Screen</li>
                                                <li>Screen Mapped to Role</li>
                                            </ul>
                                            <p><b>Module</b> field on the add/edit screen is used for mapping the screen to a module.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion5" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseFive">
                                            <a class="card-title"> Module Management</a>
                                        </div>
                                        <div id="collapseFive" class="card-body collapse" data-parent="#accordion5">
                                            <strong>Module: </strong>Module Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Create Module</li>
                                                <li>Edit Module</li>
                                                <li>Delete Module</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion6" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseSix">
                                            <a class="card-title"> Menu Management</a>
                                        </div>
                                        <div id="collapseSix" class="card-body collapse" data-parent="#accordion6">
                                            <strong>Module: </strong>Menu Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Create Menu</li>
                                                <li>Edit Menu</li>
                                                <li>Delete Menu</li>
                                                <li>Assign Menu-Item to Menu</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion7" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseSeven">
                                            <a class="card-title"> Menu Item Management</a>
                                        </div>
                                        <div id="collapseSeven" class="card-body collapse" data-parent="#accordion7">
                                            <strong>Module: </strong>Menu Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Add Menu-Item</li>
                                                <li>Edit Menu-Item</li>
                                                <li>Delete Menu-Item</li>
                                            </ul>
                                            <p class="mb-0"><strong>Form Fields:</strong></p>
                                            <ul class="no-bullets">
                                                <li>Link Type: Static URL/Dynamic Route</li>
                                                    <ul>
                                                        <li>Static URL</li>
                                                        <li>Dynamic Route - <span class="underline">Recommended only for developers</span>. Its manadatory to add 'parameters' for the routes which requries parameters, missing the parameters or adding incorrect parameter will throw error in the application.</li>
                                                    </ul>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion8" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseEight">
                                            <a class="card-title"> Category Management</a>
                                        </div>
                                        <div id="collapseEight" class="card-body collapse" data-parent="#accordion8">
                                            <strong>Module: </strong>Category Management
                                            <br>
                                            <strong>Functionalities: </strong>
                                            <ul>
                                                <li>Create Parent Category</li>
                                                <li>Edit Parent Category</li>
                                                <li>Delete Parent Category</li>
                                                <li>Manage Child Category</li>
                                            </ul>
                                             <ul>
                                                <li>Create Category</li>
                                                <li>Edit Category</li>
                                                <li>Delete Category</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-6">
                                <!-- CONTENT -->
                                <div id="accordion9" class="accordion">
                                    <div class="card mb-0">
                                        <div class="card-header collapsed" data-toggle="collapse" href="#collapseNine">
                                            <a class="card-title"> Site Setting</a>
                                        </div>
                                        <div id="collapseNine" class="card-body collapse" data-parent="#accordion9">
                                            <p>General settings of the application.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- CONTENT -->
                            </div>
                            <div class="col-md-12">
                                <p>Refer <a href="https://karthicksivakumar191194.github.io/larasnap/" target="_blank">LaraSnap Docs</a> for complete user & developer documentation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Content End-->
@endsection