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

    /*disallow cut, copy, paste for password fields*/
    $('input[type=password]').on("cut copy paste",function(e) {
        e.preventDefault();
    });

    /*disallow alaphabet "e" on number field.*/
    $('input[type=number]').on('keydown', function(e){
        return e.keyCode !== 69;
    });

    /*string to lowercase*/
    $(".lower-case").on('change keyup paste',function(){
        $(this).val($(this).val().toLowerCase());
        $(this).val($(this).val().replace(' ', '-'));
    });

});