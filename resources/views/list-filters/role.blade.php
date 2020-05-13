@if(config('larasnap.module_list.role.search'))				 
   <input type="text" name="search" placeholder="Search Role..." class="form-control ml-10" value="{{ $filters['search'] }}">
@endif				  
