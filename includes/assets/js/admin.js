(function($){
    tippy('#hq-tooltip-tenant-token');
    /*
    * Login
    * */
    $("#hq-login-trigger").on("click",function(){
        $("#hq-login-form-wrapper").slideDown();
    });
    $('#hq-submit-login-button').on('click', function(){
        try {
            login(jQuery);
        }catch (e) {
            //.alert('error');
            console.log(e);
        }
    });

})(jQuery);
function login($){
    var email = $("#hq-email").val();
    var pass = $('#hq-password').val();
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
            jQuery("#hq-api-user-token").val(response.data.data.data.user.api_token);
            jQuery("#hq-api-tenant-token").val(response.data.data.data.tenants[0].api_token);
            jQuery("#hq-api-user-base-url").val(response.data.data.data.tenants[0].api_link);
        }else{
            alert(response.data.data.errors.error_message);
        }
    }).catch( function(error) {
        jQuery(".hq-loader").slideUp();
        alert("There was an issue with your request.");
    });
}