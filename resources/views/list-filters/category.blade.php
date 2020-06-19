@if(config('larasnap.module_list.category.search'))				 
   <input type="text" name="search" placeholder="Search Category..." class="form-control ml-10" value="{{ $filters['search'] }}">
@endif				  
