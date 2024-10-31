jQuery(function($) {
    var $info = $("#plugeshin-info"),
        $doc  = $(document).height(),
        $win  = $(window).height(),
        $ts   = $("#target-selection");
    $info.dialog({                              
        'modal'         : true,
        'autoOpen'      : false, 
        'closeOnEscape' : true,
        'width'         : 725,        
        'height'     : ($doc < $win ? $doc  : $win) - 45,
        'dialogClass'   : 'wp-dialog',
        'buttons'       : {
            "Close": function() {
                $(this).dialog('close');
            }
        }
    });
    $("#plugeshin-show-info").click(function(event) {
        event.preventDefault();
        $info.dialog('open');
    });
    $("input[type=radio]", $ts).click(function() {
        $("input[type=text]", $ts).val('');
    });
    $("input[type=text]", $ts).focus(function() {
        $("input[type=radio]", $ts).prop('checked',false);
    });
});
