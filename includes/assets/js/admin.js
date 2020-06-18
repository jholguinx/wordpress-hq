(function($){
    tippy('#hq-tooltip-tenant-token');
    $('#hq-submit-login-button').on('click', function(){
        try {
            login(jQuery);
        }catch (e) {
            alert(e);
        }
    });

})(jQuery);
function login($){
    var email = $("#hq-email").val();
    var pass = $('#hq-password').val();
    $('.hq-messages-box-success').slideUp();
    $('.hq-messages-box-failed').slideUp();
    $(".hq-loader").slideDown();
    axios({
        url: hqWebsiteURL + '/wp-json/hqrentals/plugin/auth',
        data:{
            email: email,
            password: pass
        },
        params:{
            email: email,
            password: pass
        },
        method: 'get'
    }).then(function(response){
        jQuery(".hq-loader").slideUp();
        if(response.data.data.success === true){
            var tenants = response.data.data.data.tenants;
            var user = response.data.data.data.user;
            if(Array.isArray(tenants)){
                jQuery("#hq-api-user-token").val(user.api_token);
                jQuery("#hq-api-tenant-token").val(tenants[0].api_token);
                jQuery("#hq-api-user-base-url").val(tenants[0].api_link);
                $('.hq-messages-box-success').slideDown();
            }
        }else{
            $('.hq-messages-box-failed').slideDown();
        }
    }).catch( function(error) {
        jQuery(".hq-loader").slideUp();
        $('.hq-messages-box-failed').slideDown();
    });
}
