@if(config('larasnap.module_list.module.search'))				 
   <input type="text" name="search" placeholder="Search Module..." class="form-control ml-10" value="{{ $filters['search'] }}">
@endif				  
