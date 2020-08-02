@if(config('larasnap.module_list.module.search'))				 
   <input type="text" name="search" placeholder="Search Module..." class="form-control ml-10" value="{{ $filters['search'] }}" data-toggle="tooltip" data-placement="top" title="Search by module label">
@endif				  
