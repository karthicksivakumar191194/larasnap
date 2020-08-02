@if(config('larasnap.module_list.screen.search'))				 
   <input type="text" name="search" placeholder="Search Screen..." class="form-control ml-10" value="{{ $filters['search'] }}" data-toggle="tooltip" data-placement="top" title="Search by screen label">
@endif				  
