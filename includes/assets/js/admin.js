(function ($) {
    var advacedActive = false;
    tippy('#hq-tooltip-tenant-token');
    $('#hq-submit-login-button').on('click', function () {
        try {
            login(jQuery);
        } catch (e) {
            alert(e);
        }
    });
    jQuery('#hq-login-toogle-button').on('click', function () {
        loginActive = !loginActive;
        jQuery('.hq-login-wrapper').toggle(1000);
        if (loginActive) {
            onAdvancedNotActive('#hq-login-button-icon');
        } else {
            onAdvancedActive('#hq-login-button-icon');
        }
    });
    jQuery('#hq-advanced-features-toogle-button').on('click', function () {
        advacedActive = !advacedActive;
        if (advacedActive) {
            onAdvancedActive('#hq-advanced-button-icon');
        } else {
            onAdvancedNotActive('#hq-advanced-button-icon');
        }
        jQuery('.hq-advanced-section').toggle(1000);

    });
})(jQuery);

function onAdvancedActive(selector) {
    jQuery(selector).removeClass('fa-angle-down');
    jQuery(selector).addClass('fa-angle-right');
}

function onAdvancedNotActive(selector) {
    jQuery(selector).removeClass('fa-angle-right');
    jQuery(selector).addClass('fa-angle-down');
}

function login($) {
    $('.hq-messages-box-success').slideUp();
    $('.hq-messages-box-failed').slideUp();
    $(".hq-loader").slideDown();

    $.ajax(hqWebsiteURL + '/wp-json/hqrentals/plugin/auth', {
        type: 'GET',
        data: {
            email: $("#hq-email").val(),
            password: $('#hq-password').val()
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);
            jQuery(".hq-loader").slideUp();
            if (response.data.success) {
                var tenants = response.data.data.tenants;
                var user = response.data.data.user;
                console.log(tenants, user);
                if (Array.isArray(tenants)) {
                    jQuery("#hq-api-user-token").val(user.api_token);
                    jQuery("#hq-api-tenant-token").val(tenants[0].api_token);
                    jQuery("#hq-api-user-base-url").val(tenants[0].api_link);
                    jQuery("#hq-not-connected-indicator").slideUp(400, function () {
                        jQuery("#hq-connected-indicator").slideDown();
                    });
                    jQuery('.hq-messages-box-success').slideDown();
                    jQuery('.hq-login-wrapper').toggle(1000);
                    onAdvancedActive('#hq-advanced-button-icon');
                }
            } else {
                $('.hq-messages-box-failed').slideDown();
            }
        },
        error: function (response) {
            jQuery(".hq-loader").slideUp();
            $('.hq-messages-box-failed').slideDown();
        }
    }).always(function (data) {
        $('.loading-overlay').hide();
        $(".caag-software-pre-loader").fadeOut("fast");
    });
}
