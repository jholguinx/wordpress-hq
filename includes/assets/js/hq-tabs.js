jQuery(document).ready(function (){
    jQuery('#hq-tabs').tabs();
    jQuery('.trigger').on('click', function(e){
        e.preventDefault();
    })
});
