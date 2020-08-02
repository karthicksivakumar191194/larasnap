@if(config('larasnap.module_list.category_parent.search'))				 
   <input type="text" name="search" placeholder="Search Parent Category..." class="form-control ml-10" value="{{ $filters['search'] }}" data-toggle="tooltip" data-placement="top" title="Search by parent category label">
@endif				  
