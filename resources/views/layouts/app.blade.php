<!DOCTYPE html>
<html lang="en">
   @include('larasnap::layouts.head')
   <body id="page-top" class="{{ $class ?? '' }}">
      <!-- Start Page Wrapper -->
      <div id="wrapper">
         <!-- Start Sidebar -->
         @include('larasnap::layouts.sidebar')
         <!-- End Sidebar -->
         <!-- Start Content Wrapper -->
         <div id="content-wrapper" class="d-flex flex-column">
            <!-- Start Main Content -->
            <div id="content">
               <!-- Start Topbar -->
               @include('larasnap::layouts.header')              
               <!-- End Topbar -->
			   @if (config('larasnap.breadcrumb'))
			   <!-- Start Breadcrumb -->
			   @include('larasnap::layouts.breadcrumb')
			   <!-- End Breadcrumb -->
			   @endif
               <!-- Start Page Content -->
               <div class="container-fluid">
			   <!-- start success message -->
			    @if (session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ session('success') }}          
                    </div>
				@endif	
				<!-- end success message -->
			    <!-- start error message -->
			    @if (session('error'))				
				    <div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ session('error') }}
					</div>
				@endif					
				 <!-- end error message -->
                  @yield('content')
               </div>
               <!-- End Page Content -->
            </div>
            <!-- End Main Content -->
            <!-- Footer Copyright -->
            @include('larasnap::layouts.footer')
            <!-- End of Footer Copyright -->
         </div>
         <!-- End  Content Wrapper -->
      </div>
      <!-- End Page Wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      @include('larasnap::layouts.foot')
      @yield('script')
   </body>
</html>