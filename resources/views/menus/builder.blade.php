@extends('larasnap::layouts.app', ['class' => 'menu-builder'])
@section('title','Menu Management')
@section('content')
<!-- Page Heading  Start-->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
   <h1 class="h3 mb-0 text-gray-800">Assign Menu-Item to Menu({{ $menu->name }})</h1>
</div>
<!-- Page Heading End-->				  
<!-- Page Content Start-->				  
<div class="row">
   <div class="col-xl-12">
      <div class="card shadow mb-4">
         <div class="card-body">
            <div class="card-body">
               <a href="{{ route('menus.index') }}" title="Back to Users List" class="btn btn-warning btn-sm"><i aria-hidden="true" class="fa fa-arrow-left"></i> Back to Menus List
               </a> 
			   <a href="" title="Add New Menu Item" class="btn btn-success btn-sm add_item" style="float:right;"><i aria-hidden="true" class="fa fa-plus"></i> Add New Menu-Item</a>
               <br> <br>
			   <div class="dd">
			   {!! menu($menu->name, 'admin') !!}	
				</div>
<!-- Menu -->
<!-- <div class="dd">
   <ol class="dd-list">
      <li class="dd-item" data-id="1">
         <div class="pull-right item_actions">
            <div class="btn btn-sm btn-danger pull-right delete" data-id="1" title="Delete Menu Item">
               <i class="fa fa-trash"></i> 
            </div>
            <div class="btn btn-sm btn-primary pull-right edit edit_item" data-id="1" data-title="Dashboard" data-url="" data-target="_self" data-icon_class="" data-color="#000000" data-route="" data-parameters="null" title="Edit Menu Item">
               <i class="fa fa-pencil-square-o"></i> 
            </div>
         </div>
         <div class="dd-handle">
            <span>Dashboard</span> <small class="url">/admin</small>
         </div>
      </li>
      <li class="dd-item" data-id="2">
         <div class="dd-handle">Item 2</div>
      </li>
      <li class="dd-item" data-id="3">
         <div class="dd-handle">Item 3</div>
         <ol class="dd-list">
            <li class="dd-item" data-id="4">
               <div class="dd-handle">Item 4</div>
            </li>
            <li class="dd-item" data-id="5">
               <div class="dd-handle">Item 5</div>
            </li>
         </ol>
      </li>
   </ol>
</div> -->
<!-- Menu -->
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Menu Modal -->
<div id="menu_item_modal" class="modal fade" role="dialog" data-modal="add">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
	  <h4 class="modal-title add-title" style="display:none;">Create a New Menu-Item</h4>
	  <h4 class="modal-title edit-title" style="display:none;">Edit Menu Item</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	  <form id="m_form" action="{{ route('menus.item_store', $menu->id ) }}" method="POST" >
	  @csrf
      @method('post')
      <div class="modal-body">
  <div class="form-group">
    <label for="title">Title of the Menu-Item</label>
    <input type="text" class="form-control" name="title" id="title" >
  </div> 
  <div class="form-group">
    <label for="font-icon">Font Icon class for the Menu-Item (<a href="{{ route('docs.icons') }}" target="_blank">Click here</a> for sample icons)</label>
    <input type="text" class="form-control" name="font_icon" id="font-icon" placeholder="fa-user">
  </div>  
    <div class="form-group">
    <label for="link-type">Link type</label>
    <select class="form-control" name="link_type" id="link-type">
      <option value="url">Static URL</option>
      <option value="route">Dynamic Route</option>
    </select>
  </div>
  <div class="form-group" id="url-type">
    <label for="url">URL for the Menu-Item</label>
    <input type="text" class="form-control" name="url" id="url">
  </div>
  <div class="form-group" id="route-type" style="display: none;">
    <label for="route">Route for the Menu-Item</label>
    <input type="text" class="form-control" name="route" id="route" placeholder="users.index">
	</br>
	<label for="parameters">Route parameters (if any)</label>
    <textarea rows="3" class="form-control" id="parameters" name="parameters" placeholder="{{ json_encode(['key' => 'value'], JSON_PRETTY_PRINT) }}"></textarea></br>

      </div>
	      <div class="form-group">
    <label for="target">Open In</label>
    <select class="form-control" name="target" id="target">
      <option value="_self">Same Tab/Window</option>
      <option value="_blank">New Tab/Window</option>
    </select>
  </div>
  <input type="hidden" name="menu_id" value="{{ $menu->id }}">
  <input type="hidden" name="menu_item_id" id="menu-item-id" >
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success submit-button">Add</button>
      </div>
	  </form>
    </div>

  </div>
</div>
<!-- Menu Modal -->
<!-- Page Content End-->
<style>
.menu-item-destroy{
    display: inline;
}
@media (min-width: 481px) {
    .ajax-alert, .alert {
      position: absolute;
      right: 25px;
      width: 320px;
    }
}
</style>
@endsection
@section('script')
<script>
$(document).ready(function () {          
   $('.dd').nestable({
       expandBtnHTML: '',
       collapseBtnHTML: ''
   });

   /*Menu Item Pop-Up validation*/
   $('#m_form').on('submit', function () {
       $('.mi-error').remove();

       var $mi_title = $('#title').val();
        if($mi_title == ''){
            $mi_title_e_msg = '<span class="text-danger mi-error">The Title of the Menu Item field is required.</span>';
            $('#title').focus();
            $('#title').parents('.form-group').append($mi_title_e_msg);
            return false;
        }else{
            $('.mi-error').remove();
        }
   });
   
   /** Set Variables */
    var $m_modal = $('#menu_item_modal'),
        $m_form  = $('#m_form'),
		$m_add_title = $('.add-title'),
		$m_edit_title = $('.edit-title'),
		$m_link_type = $("#link-type"),
		$m_url_type = $("#url-type"),
		$m_route_type = $("#route-type");
               
   /** Add Menu Item*/
   $('.add_item').click(function(e) {
	    e.preventDefault();
		$m_add_title.show();
		$m_edit_title.hide();
		$m_modal.attr('data-modal', 'add');
        $m_form.find("input[name=_method]").val('POST');
        $m_form.find(".submit-button").html('Save');
        $m_modal.modal('show');
       /*reset pre menu item data*/
       $("#title").val('');
       $("#font-icon").val('');
       $("#url").val('');
       $("#route").val('');
       $("#parameters").val('');
       $("#menu-item-id").val('');
       $("#link-type").find("option[value='url']").attr('selected', 'selected');
       $("#url-type").show();
       $("#route-type").hide();
       $("#target").find("option[value='_self']").attr('selected', 'selected');
       /*reset pre menu item data*/
    });

   /** Edit Menu Item*/
   $('.edit_item').on('click', function (e) {
	     e.preventDefault();
         var _src = $(this).data();
		 $m_add_title.hide();
		 $m_edit_title.show();		 
		 $m_modal.attr('data-modal', 'edit');
         $m_form.find("input[name=_method]").val('PUT');
         $m_form.find(".submit-button").html('Update');
         /*pre menu item data*/
         $("#title").val(_src.title);
         $("#font-icon").val(_src.icon);
         $("#url").val(_src.url);
         $("#route").val(_src.route);
         $("#parameters").val((JSON.stringify(_src.parameter)));
         $("#menu-item-id").val(_src.id);
         if(!_src.route){ 
            $("#link-type").find("option[value='url']").attr('selected', 'selected');
            $("#url-type").show();
            $("#route-type").hide();
         }else{
             $("#link-type").find("option[value='route']").attr('selected', 'selected');
             $("#url-type").hide();
             $("#route-type").show();
         }
         if(_src.target == '_self'){
             $("#target").find("option[value='_self']").attr('selected', 'selected');
         }else{
             $("#target").find("option[value='_blank']").attr('selected', 'selected');
         }
         /*pre menu item data*/
         $m_modal.modal('show');
   });
   
    /** Menu ItemModal is Open */
    $m_modal.on('show.bs.modal', function(e, data) {
		var modal_type = $(e.currentTarget).attr('data-modal'); 
		console.log(modal_type);
	});
   
   /** Toggle Form Menu Type */
   $m_link_type.on('change', function (e) {
       if ($m_link_type.val() == 'route') {
           $m_url_type.hide();
           $("#url").val('');
           $m_route_type.show();
       } else {
            $m_url_type.show();
            $m_route_type.hide();
            $("#route").val('');
       }
   });
   
   /** Reorder items **/
   $('.dd').on('change', function (e) {
		var itemOrder = JSON.stringify($('.dd').nestable('serialize'));
		//console.log('Item Order: '+itemOrder);
        $(".ajax-alert").fadeOut(300, function(){ $(this).remove(); })
		$.post('{{ route('menus.order',['menu' => $menu->id]) }}', {
               order: itemOrder,
               _token: '{{ csrf_token() }}'
             }, function (data) {
                    var success_msg =
                        '<div class="alert alert-success ajax-alert"> ' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                        'Menu Item updated successfully!</div>';
                    $(".container-fluid").prepend(success_msg);
                    //remove success msg in 3 sec
                    setTimeout(function(){
                        $(".ajax-alert").fadeOut(300, function(){ $(this).remove(); })
                    }, 3000);
			 }
		 );
   });
   
});

setTimeout(function(){
    $(".alert").fadeOut(300, function(){ $(this).remove(); })
}, 3000);

</script>

@endsection