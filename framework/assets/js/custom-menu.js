jQuery(document).ready(function($){
    "use strict";
    /* Menu Changed */
    var $menu = $('#menu-to-edit');
    var $twChangeIntStep=100;
    var $twChange=$twChangeIntStep;
    $menu.on( 'tw-change', function( event, ui ) {        
        var $mega=false;
        $('>li',$(this)).each(function(){
            if($(this).hasClass('menu-item-depth-0')){
                if($('.field-waves.field-waves-is-mega input',$(this)).is(':checked')){
                    $mega=true;
                }else{
                    $mega=false;
                }
            }
            if($mega){
               $(this).addClass('tw-mega-item');
            }else{
                $(this).removeClass('tw-mega-item');
            }
        });
    } );
    $menu.on('DOMSubtreeModified', function() {$twChange=1000;});
    setInterval(function(){
        if($twChange!=='no-change'){
            $twChange-=$twChangeIntStep;
            if($twChange<=0){
                $twChange='no-change';
                $menu.trigger('tw-change');
            }
        }
    },$twChangeIntStep);
    $(document).on('change','.field-waves.field-waves-is-mega input',function(){$menu.trigger('tw-change');});
});