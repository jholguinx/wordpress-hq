jQuery(document).ready(function (){
    jQuery('#hq-tabs').tabs();
    jQuery('.trigger').on('click', function(e){
        console.log(e);
        e.preventDefault();
    })
});
