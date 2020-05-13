@if(config('larasnap.module_list.menu.search'))				 
   <input type="text" name="search" placeholder="Search Menu..." class="form-control ml-10" value="{{ $filters['search'] }}">
@endif				  
