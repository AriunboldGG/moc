/* Resize */
function showHidePostFormatField(){
    "use strict";
    jQuery('#normal-sortables>[id*="tw-format-"]').each(function(){
        if ( jQuery('#post-formats-select input:radio:checked') . length ) {
            if(jQuery(this).attr('id').replace("tw","post")===jQuery('#post-formats-select input:radio:checked').attr('id').replace('image', 'gallery')){
                jQuery(this).css('display', 'block');
            } else {
                jQuery(this).css('display', 'none');
            }
        }
    });    
}
jQuery(function($){
    "use strict";

    /* Type Layout */
    $( "body" ).on( "click",".type_layout>a",function(e){e.preventDefault();
        var $c=$(this);
        $c.addClass('active').siblings('.active').removeClass('active');
        $c.siblings('input').val($c.data('value')).trigger('change');
    });

    /* Type CheckBox */
    $( 'body' ).on( 'change', '.waves-type-checkbox [type="checkbox"]', function ( e ) { e.preventDefault();
        var $c = $( this );
        var $h = $c.siblings('[type="hidden"]');
        if ( $h.length ) {
            $h.val( $c.is(':checked') ? '1' : '0' );
        }
    });
    
    /* Page template */
    var pages = $("#page_template");
    var pageMetas = $("#tw-onepage-options,#tw-fullpage-options,#tw-splitpage-options,#tw-magazinepage-options");
    var pageOpt = $("#tw-page-options");
    pages.bind('change', function(){
        var template = $(this).val().split('.php')[0];
        if(template === 'default'){
            pageMetas.stop().fadeOut();
            pageOpt.stop().fadeIn();
        } else {
            if(template !== 'page-onepage'){
                pageOpt.stop().fadeOut();
            } else {
                pageOpt.stop().fadeIn();
            }
            pageMetas.stop().fadeOut().filter(template.replace(/page-/gi, '#tw-')+'-options').stop().fadeIn();
        }
    });
    pages.change();
    
    /* Select */
    $(document).on("change",'select',function(){
        $('option[value="'+$(this).val()+'"]',$(this)).attr('selected','selected').siblings('option').removeAttr('selected');
    });
    /* Post Select */
    $(document).on("change",'.tw-selectpost-container .tw_selectpost',function(){
        var $cont=$(this).closest('.tw-selectpost-container');
        var $btn=$('a',$cont);
        var $val=$('option[value="'+$(this).val()+'"]',$(this)).data('id');
        $cont.attr('data-option',$val?$val:'');
        $btn.attr('href',$btn.data('href').replace('%post%',$val));
    });
    
    /* Block Rows */
    var $tmp=$('.type_rows>.type_rows-item').last().clone();
    $( "body" ).on( "click", ".type_rows .type_rows-item-remove", function(e){e.preventDefault();$(this).closest('.type_rows-item').remove();return false;});
    $( "body" ).on( "click", ".type_rows .type_rows-item-add", function(e){e.preventDefault();
        var $crBtnAdd=$(this);
        var $crRowCont=$crBtnAdd.closest('.type_rows');
        if($('>.type_rows-item',$crRowCont).length){
            var $newRw=$('>.type_rows-item',$crRowCont).last();
            $newRw.find('select').change();
            $tmp=$newRw.clone();
        }
        $crBtnAdd.closest('.add-buttons').before($tmp.clone());
        return false;
    });
    $( "body" ).on( "click", ".type_rows .type_rows-item-move", function(e){e.preventDefault();
        var $type=$(this).data('type');
        var $row=$(this).closest('.type_rows-item');
        if($type==='up'){
            $row.insertBefore($row.prev('.type_rows-item'));
        }else{
            $row.insertAfter($row.next('.type_rows-item'));
        }
        return false;
    });
    
    /* Dependency */
    $('[data-dependency]').each(function(){
        var $cr=$(this);
        var $dep=$(this).data('dependency');
        var $name=$dep.element;
        var $el=$cr.siblings('[data-name="'+$name+'"]');
        var $elField=$el.find('[name="'+$name+'"]').length?$el.find('[name="'+$name+'"]'):$el.find('select,input');
        var $elChild=$el.data('def-child');
        if($elChild){
            $elChild.push($cr.data('name'));
        }else{
            $elChild='["'+$cr.data('name')+'"]';
        }
        $el.attr('data-def-child',$elChild);
        $elField.off('change').on('change',function(){
            if($elField.attr('type')=='checkbox'){$elField.val($elField.is(':checked')?'1':'0');}            
            $elChild=$el.data('def-child');
            for (var i = 0; i < $elChild.length; i++) {
                var $cEC=$el.siblings('.'+$elChild[i]);
                var $cDep=$cEC.data('dependency');
                var $value=$cDep.value;
                var $elSubChild=$cEC.data('def-child');
                var $hiden=true;
                if($value.indexOf($elField.val())==-1||$el.css('display')==='none'){
                    $cEC.hide();
                }else{
                    $hiden=false;
                    $cEC.show();
                }
                if($elSubChild){
                    for(var j in $elSubChild){
                        if($hiden){
                            $cEC.siblings('.'+$elSubChild[j]).hide();
                        }else{
                            $cEC.find('[name="'+$cEC.data('name')+'"]').change();
                        }
                    }
                }
            }
        });
        setTimeout(function(){$elField.trigger('change');},1000);
    });
    
    /* Show Filter */
    setTimeout(function(){
        $('#blog_meta_settings .type_select>[name="show_filter"],#port_meta_settings .type_select>[name="show_filter"]').bind('change',function(){
            if($(this).val()==='true'){
                $(this).closest('#show_filter').siblings('#filter_type').show();
            }else{
                $(this).closest('#show_filter').siblings('#filter_type').hide();
            }
        }).change();
    },100);
    	
    /* Color Picker */
    $(".color_picker").each(function(){
        var $currColPick=$(this);
        var $currColor=$currColPick.next('.color_picker_value').val();
        $currColPick.wavesColorPicker({
            color:$currColor,
            onShow: function (colpkr) {
                $(colpkr).stop().fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).stop().fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb, el) {
                $(el).parent().find('.color_picker_inner').css('background-color', '#' + hex);
                $(el).parent().find('.color_picker_value').val('#' + hex);
            }
        });
    });
    
    /* Post format */
    showHidePostFormatField();
    $('#post-formats-select input').change(showHidePostFormatField);
    
    
    /* Gallery */
    
    var frame;
    $('.gallery_upload').on('click', function(e) {e.preventDefault();
        var $currBtn = $(this);
        var $currField = $currBtn.siblings('.gallery_images');
        var $currThumb = $currBtn.siblings('.gallery-thumbs');
        var selection = loadImages($currField.val());
        /* Set options for 1st frame render */
        var options = {
                title: lvly_script_data.label_create,
                state: 'gallery-edit',
                frame: 'post',
                selection: selection
        };

        /* Check if frame or gallery already exist */
        if( frame || selection ) {
                options['title'] = lvly_script_data.label_edit;
        }

        frame = wp.media(options).open();

        /* Tweak views */
        frame.menu.get('view').unset('cancel');
        frame.menu.get('view').unset('separateCancel');
        frame.menu.get('view').get('gallery-edit').el.innerHTML = lvly_script_data.label_edit;
        frame.content.get('view').sidebar.unset('gallery'); /* Hide Gallery Settings in sidebar */

        /* When we are editing a gallery */
        overrideGalleryInsert();
        frame.on( 'toolbar:render:gallery-edit', function() {overrideGalleryInsert();});

        frame.on( 'content:render:browse', function( browser ) {
            if ( !browser ) return;
            /* Hide Gallery Setting in sidebar */
            browser.sidebar.on('ready', function(){
                browser.sidebar.unset('gallery');
            });
            /* Hide filter/search as they don't work  */
                browser.toolbar.on('ready', function(){ 
                        if(browser.toolbar.controller._state === 'gallery-library'){ 
                                browser.toolbar.$el.hide(); 
                        } 
                }); 
        });

        /* All images removed */
        frame.state().get('library').on( 'remove', function() {
            var models = frame.state().get('library');
                if(models.length === 0){
                    selection = false;
                    $.post(ajaxurl, { 
                        ids: '',
                        action: 'lvly_save_images',
                        post_id: lvly_script_data.post_id,
                        nonce: lvly_script_data.nonce 
                    });
                }
        });

        /* Override insert button */
        function overrideGalleryInsert() {
                frame.toolbar.get('view').set({
                        insert: {
                                style: 'primary',
                                text: lvly_script_data.label_save,

                                click: function() {                                            
                                        var models = frame.state().get('library'),
                                            ids = '';

                                        models.each( function( attachment ) {
                                            ids += attachment.id + ',';
                                        });

                                        this.el.innerHTML = lvly_script_data.label_saving;

                                        $.ajax({
                                                type: 'POST',
                                                url: ajaxurl,
                                                data: { 
                                                    ids: ids, 
                                                    action: 'lvly_save_images', 
                                                    post_id: lvly_script_data.post_id, 
                                                    nonce: lvly_script_data.nonce 
                                                },
                                                success: function(){
                                                    selection = loadImages(ids);
                                                    $currField.val( ids );
                                                    frame.close();
                                                },
                                                dataType: 'html'
                                        }).done( function( data ) {
                                            $currThumb.html( data );
                                        }); 
                                }
                        }
                });
        }
    });

    /* Load images */
    function loadImages(images) {
            if( images ){
                var shortcode = new wp.shortcode({
                    tag:    'gallery',
                    attrs:   { ids: images },
                    type:   'single'
                });

                var attachments = wp.media.gallery.attachments( shortcode );

                var selection = new wp.media.model.Selection( attachments.models, {
                        props:    attachments.props.toJSON(),
                        multiple: true
                });

                selection.gallery = attachments.gallery;

                /* Fetch the query's attachments, and then break ties from the */
                /* query to allow for sorting. */
                selection.more().done( function() {
                        /* Break ties with the query. */
                        selection.props.set({ query: false });
                        selection.unmirror();
                        selection.props.unset('orderby');
                });

                return selection;
            }
            return false;
    }
    /* Image */
    $(".tw-browseimage").on('click', function(e){e.preventDefault();
        var $currBtn = $(this);
        var $currBtnTxt = $currBtn.text();
        var $loadingTxt = 'Loading...';
        if($currBtnTxt!==$loadingTxt){
            $currBtn.text($loadingTxt);
            window.original_send_to_editor = window.send_to_editor;
            window.custom_editor = true;    
            window.send_to_editor = function(html){
                if(html){
                    $('<div>'+html+'</div>').find('img').each(function(){
                        var imgurl = $(this).attr('src');
                        $currBtn.siblings('input').val(imgurl); 
                    });
                    $currBtn.text($currBtnTxt);
                }
            };
            wp.media.editor.open();
        }
    });
});