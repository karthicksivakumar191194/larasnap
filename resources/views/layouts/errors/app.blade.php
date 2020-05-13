<!DOCTYPE html>
<html lang="en">
   @include('larasnap::layouts.head')
   <body id="" class="">
      <div class="container">
         <div id="error-main">
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <div class="error-template">
                        <h2>
                           @yield('heading')
                        </h2>
                        <div class="error-details">
                           @yield('content')
                        </div>
                        <div class="error-actions">
                           <a href="{{ route(config('larasnap.general.dashboard_route_name')) }}" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                           Take Me Home </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @include('larasnap::layouts.foot')
   </body>
</html>