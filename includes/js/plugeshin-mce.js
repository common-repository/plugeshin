(function($) { 
    $("#plugeshin-dialog").delegate("input[name=plugeshin-line-numbers]", "click", function() {
        var $this = $(this), $notice = $("#plugeshin-num-notice");
        if (this.value === '1') {
            $notice.hide();
            $("#plugeshin-dialog input[name=plugeshin-start]").removeAttr("disabled").css("background-color","#FFF");
        } else {
            $notice.show();
            $("#plugeshin-dialog input[name=plugeshin-start]").attr("disabled", "disabled").css("background-color","#AEAEAE");
        }                         
    });
    $( "#plugeshin-dialog" ).dialog({                                        
        'modal'         : true,
        'autoOpen'      : false, 
        'closeOnEscape' : true,
        'width'         : 800,
        'buttons'       : {
                "Wrap with PluGeSHin shortcode": function() {
                    var ed              = tinymce.plugins.plugeshin.theEd,
                        selectNode      = ed.selection.getNode(),
                        theAttributes   = '',                        
                        newContent, temp, $temp;                    
                        
                    temp = $("#plugeshin-dialog select option:selected").val();
                    if (temp.length > 0) {
                        theAttributes +=    ' lang="' + temp + '" ';                         
                    }
                    
                    temp = $("#plugeshin-dialog input[name=plugeshin-line-numbers]:checked").val();                    
                    if (temp.length > 0) {
                        theAttributes +=    ' nums="' + temp + '" ';                         
                    }
                    
                    temp = $("#plugeshin-dialog input[name=plugeshin-start]").val();
                    if (temp.length > 0) {
                        theAttributes +=    ' start="' + temp + '" ';                         
                    }
                    
                    temp = $("#plugeshin-dialog input[name=plugeshin-extra]").val();
                    if (temp.length > 0) {
                        theAttributes +=    ' highlight="' + temp + '" ';                         
                    }
                                                                                                                        
                    temp = $("#plugeshin-dialog input[name=plugeshin-target-frame]").val();
                    if (temp.length < 1) {
                        $temp = $("#plugeshin-dialog input[name=plugeshin-target]:checked");
                        if ($temp.length > 0 ) {
                            temp = $temp.val();
                        }                        
                    }                    
                    if (temp.length > 0) {
                        theAttributes +=    ' target="' + temp + '" ';                         
                    }  
                                                                                                                                                     
                    newContent = '<p>[geshi' + theAttributes + ']</p><pre>' + ed.selection.getContent({format : 'text'}) + '</pre><p>[/geshi]</p>';                      
                     ed.selection.setContent(newContent);         
                     ed.undoManager.add(); 
                                        
                    $( this ).dialog( "close" );
                },
                "Cancel": function() {
                    $( this ).dialog( "close" );
                }
        }
    }); 
    $( "#plugeshin-dialog" ).parent().attr("class", "ui-dialog ui-widget ui-widget-content ui-corner-all wp-dialog ui-draggable ui-resizable");       
    var simpleShortCode = function() {
        var ed         = tinymce.plugins.plugeshin.theEd,
            selectNode = ed.selection.getNode(),
            newContent = '<p>[geshi]</p><pre>' + ed.selection.getContent({format : 'text'}) + '</pre><p>[/geshi]</p>';                      
         ed.selection.setContent(newContent);         
         ed.undoManager.add();
    }
    tinymce.create('tinymce.plugins.plugeshin', {
        init : function(ed, url) {
            tinymce.plugins.plugeshin.theUrl = url;
            tinymce.plugins.plugeshin.theEd  = ed;                       
        },
        createControl : function(n, cm) {
            switch (n) {
                case 'plugeshin':
                    var c = cm.createSplitButton('mysplitbutton', {
                        title : 'Add PluGeSHin shortcode',
                        image : tinymce.plugins.plugeshin.theUrl + '/../geshi.png',
                        onclick : simpleShortCode
                    });
    
                    c.onRenderMenu.add(function(c, m) {
                        m.add({title : 'PluGeSHin', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
    
                        m.add({ title : '[geshi]...[/geshi]', 
                                onclick : simpleShortCode
                        });
    
                        m.add({ title : '[geshi w/ ATTRIBUTES]...[/geshi]', 
                                onclick : function() {
                                    $( "#plugeshin-dialog" ).dialog('open');                                                                                                           
                                }
                        });
                    });
    
                    // Return the new splitbutton instance
                    return c;  
            }
            return null;
        }
    });
    tinymce.PluginManager.add('plugeshin', tinymce.plugins.plugeshin);    
})(jQuery);