<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
   <!-- Sidebar Toggle (Topbar) -->
   <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
   <i class="fa fa-bars"></i>
   </button>
   <!-- Topbar Navbar -->
   <ul class="navbar-nav ml-auto">
      <!-- Nav Item - Alerts -->
      <li class="nav-item dropdown no-arrow mx-1">
         <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter">3+</span>
         </a>
         <!-- Dropdown - Alerts -->
         <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
               Alerts Center
            </h6>
            <a class="dropdown-item d-flex align-items-center" href="#">
               <div class="mr-3">
                  <div class="icon-circle bg-primary">
                     <i class="fas fa-file-alt text-white"></i>
                  </div>
               </div>
               <div>
                  <div class="small text-gray-500">Nov 19, 2020</div>
                  <span class="font-weight-bold">Alert Test!</span>
               </div>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="#">
               <div class="mr-3">
                  <div class="icon-circle bg-warning">
                     <i class="fas fa-exclamation-triangle text-white"></i>
                  </div>
               </div>
               <div>
                  <div class="small text-gray-500">Nov 19, 2020</div>
                  Alert Test!
               </div>
            </a>
            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
         </div>
      </li>
      <div class="topbar-divider d-none d-sm-block"></div>
      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
         <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->userProfile ? auth()->user()->userProfile->first_name .' '. auth()->user()->userProfile->last_name : '- NA -' }}</span>
         <img class="img-profile rounded-circle" src="{{ auth()->user()->avatar }}" >
         </a>
         <!-- Dropdown - User Information -->
         <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            My Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
            </a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
             </form>
         </div>
      </li>
   </ul>
</nav>