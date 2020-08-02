/** SortBy, Filters Start - Inputs: value of dropdowns(used on switch case options) | #bulk-checkall, .bulk-check, .bulk-check > attr('data-id'), #actions, #list-form , .assign-check, .assign-check > attr('data-msg')**/

/*use for filters which use static values - Eg. sort by*/
function filter(operation) {
    switch (operation) {
        case "latestfirst":
        case "oldestfirst":
            sortBy();
            break;
    }
}

/*use for filters which use dynamic values - where options are dynamically generated from DB*/
function filterByID(el){
    var name = el.name;
    var value = el.value;
    sortBy();
}

function sortBy() {
    $("input[name=_method]").val('POST');
    $("#list-form").submit();
}

/*use for filters which works on bulk action(using check all, check funcionalities)*/
function filterBulk(operation){
    var idsArr = [];
    $(".bulk-check:checked").each(function () {
        idsArr.push($(this).attr('data-id'));
    });
    /* Default Bulk Check Start*/
    if (idsArr.length <= 0) {
        $('#actions').val(0);
        alert("Please select atleast one record to "+operation+".");
    }
    /* Default Bulk Check End*/
    else {
        switch (operation) {
            case "delete":
                if(confirm("Are you sure, you want to "+operation+" the selected records?")){
                    $("input[name=_method]").val('DELETE');
                    $("#list-form").submit();
                }
                break;
        }
    }
}

/** SortBy, Filters End **/

function individualDelete(id){
    if(confirm("Are you sure, you want to delete the record?")){
        $("input[name=_method]").val('DELETE');
        var action_url = $("#list-form").prop('action');
        var new_action_url = action_url +'/'+id;
        $("#list-form").attr('action', new_action_url);
        $("#list-form").submit();
    }else{
        return false;
    }
}

$(document).ready(function () {

    /* Bulk Check */
    $('#bulk-checkall').on('click', function(e) {
        if($(this).is(':checked',true)){
            $(".bulk-check").prop('checked', true);
        } else {
            $(".bulk-check").prop('checked',false);
        }
    });

    /* Single Check */
    $('.bulk-check').on('click',function(){
        if($('.bulk-check:checked').length == $('.bulk-check').length){
            $('#bulk-checkall').prop('checked',true);
        } else {
            $('#bulk-checkall').prop('checked',false);
        }
    });

    /*User Maximum Role Selection*/
    if(typeof maximum_roles_selection !== 'undefined' && maximum_roles_selection > 0){
        $("#bulk-checkall").attr("disabled", true);
        $(".assign-check").change(function () {
            var roles_selected = $(".bulk-check:checked").length;

            if (roles_selected > maximum_roles_selection){
                $(this).prop("checked", "");
                $("#bulk-checkall").prop("checked", "");
                var module = $(this).attr('data-msg');
                alert('Maximum ' + maximum_roles_selection +' '+ module +'.');
            }
        });
    }
    
    /*Auto Complete - Inputs: .autocomplete | .autocomplete-value | .autocomplete-id | #autocompleteList | #autocompleteList > data-id, data-value*/
    $('.autocomplete').keyup(function(e){
         $('.autocomplete-id').val('');
        /*When Backspace or Delete is hit, clear the 'id' & close the autocomplete list*/
        if (e.keyCode == 8 || e.keyCode == 46) { 
           closeAutoCompleteList();
        }
        var input = $(this).val();  
        if(input != '' && typeof autocomplete_url !== 'undefined' && autocomplete_url !== ''){
             $.ajax({  
                url:autocomplete_url,  
                type:"GET",  
                data:{input:input},
                beforeSend:function(){
                   $('#autocompleteList').html('');  
                },    
                success:function(data){  
                    //console.log('AutoComplete Success Response: ', data);
                    $('#autocompleteList').fadeIn();  
                    $('#autocompleteList').html(data);  
                },
                error:function(er){
                    console.log('AutoComplete Error: ', er);
                }    
            });
        }
    }); 
    //click event on dynamically added elements
    $('#autocompleteList').on('click', 'li', function(){ 
        var id = $(this).attr('data-id');
        var value = $(this).attr('data-value');
        $('.autocomplete-value').val(value);
        $('.autocomplete-id').val(id);
        closeAutoCompleteList();
    });
    
    function closeAutoCompleteList(){
       $('#autocompleteList').fadeOut();  
       $('#autocompleteList').html(''); 
    }
    
    /*disallow cut, copy, paste for password fields*/
    $('input[type=password]').on("cut copy paste",function(e) {
        e.preventDefault();
    });

    /*disallow alaphabet "e" on number field.*/
    $('input[type=number]').on('keydown', function(e){
        return e.keyCode !== 69;
    });

    /*string to lowercase*/
    $(".lower-case").on('change keyup keydown paste',function(){
        $(this).val($(this).val().toLowerCase());
        $(this).val($(this).val().replace(' ', '-'));
    });
    
    /*screen - add module | show input field - Inputs: .add-module*/
    $(".add-module").on('click', function(){
        var targetID = '#' + $(this).attr('class'); 
        if($(targetID).is(":visible")){
           $(targetID).addClass('hide-add-module'); 
        }else{
           $(targetID + ' input').val(''); 
           $(targetID + ' #new-module-error').remove(); //dynamically generated element 
           $(targetID).removeClass('hide-add-module'); 
        }
    });
    /*screen - add module | save new module to storage - Inputs: #add-new-module, #new-module, #add-module*/
    $("#add-new-module").click(function(){
        var input = $("#new-module").val();
        if(input == ''){
            $("#new-module").after('<span id="new-module-error" class="text-danger dy-err">The new module field is required.</span>');
            return;
        }else{
            $("#new-module-error").remove(); //dynamically generated element 
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({  
           url:autocomplete_url,  
           type:"POST",  
           data:{input:input},
           beforeSend:function(){
                $("#new-module-error").remove(); //dynamically generated element 
           },    
           success:function(data){  
               console.log('New Module Add Success Response: ', data);
               if('error' in data){
                   $("#new-module").after('<span id="module-field-error" class="text-danger dy-err">' + data.error.input[0] + '</span>');
               }
               if(typeof data !== 'undefined' && typeof data.success !== 'undefined' ){
                   $('#add-module').addClass('hide-add-module'); 
                   alert(data.success);
               }
           },
           error:function(er){
               console.log('New Module Add Error: ', er);
           }    
         });       
    });
    
    /*Module Add - Inputs: .module-add-form, .module-edit-form, #module-label, .module-add*/
    $(".module-add").on('click', function(e){
        e.preventDefault();
        $(".module-add-form").show();
        $(".module-edit-form").hide();
        $("#module-field-error").remove(); //dynamically generated error element 
        $("#module-label").focus();
        $(".module-add").hide();
    });
    
    /*Module Edit - Inputs: .module-add-form, .module-edit-form, #module-edit-label, #module-edit-id, .module-add*/
    $(".module-edit").on('click', function(e){
        e.preventDefault();
        var id = $(this).attr('data-id');
        var label = $(this).attr('data-label');
        $(".module-add-form").hide();
        $(".module-edit-form").show();
        $("#module-field-error").remove(); //dynamically generated error element 
        $("#module-edit-label").val(label);
        $("#module-edit-label").focus();
        $("#module-edit-id").val(id);
        $(".module-add").show();
    });
    
    /*Module add & update - Inputs: #module-submit, #module-update, .module-add-form, #module-label, .module-add-form form, .module-edit-form, #module-edit-label, .module-edit-form form, #module-edit-id*/
    $("#module-submit, #module-update").click(function(e){ 
        e.preventDefault();
        
        if($(".module-add-form").is(':visible')){ 
             var ref = $("#module-label");
             var input = ref.val();
             var url = $(".module-add-form form").attr('action');
             var type = 'POST';
        }else if($(".module-edit-form").is(':visible')){ 
             var ref = $("#module-edit-label");
             var input = ref.val();
             var url = $(".module-edit-form form").attr('action') + '/' + $("#module-edit-id").val();
             var type = 'PUT';
        }else{ 
            return
        }
        
        if(input == ''){
            ref.after('<span id="module-field-error" class="text-danger dy-err">The label field is required.</span>');
            return;
        }else{
            $("#module-field-error").remove(); //dynamically generated element 
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({  
           url: url,  
           type: type,  
           data:{label:input},
           beforeSend:function(){
                $("#module-field-error").remove(); //dynamically generated element
           },    
           success:function(data){  
               console.log('Module CRUD Success Response: ', data);
               location.reload();
           },
           error:function(er){
               console.log('Module CRUD Error: ', er);
               var validationError = er.responseJSON;
               if('errors' in validationError){
                   ref.after('<span id="module-field-error" class="text-danger dy-err">' + validationError.errors.label[0] + '</span>');
               }
           }    
         });       
    });
    
});