@if(config('larasnap.module_list.role.search'))				 
   <input type="text" name="search" placeholder="Search Role..." class="form-control ml-10" value="{{ $filters['search'] }}" data-toggle="tooltip" data-placement="top" title="Search by role label">
@endif				  
