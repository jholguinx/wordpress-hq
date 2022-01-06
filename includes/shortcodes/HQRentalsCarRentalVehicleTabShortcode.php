<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

class HQRentalsCarRentalVehicleTabShortcode
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_vehicles_tabs', array($this, 'render'));
    }

    public function render($atts = [])
    {
        $atts = shortcode_atts(
            array(
                'title' => '',
                'forced_locale' => 'en',
                'autoscroll' => 'true'
            ), $atts
        );
        $query = new HQRentalsDBQueriesVehicleClasses();
        $vehicles = $query->allVehicleClasses();
        return "
            <div id='vehicles' class='container'>
	            <div class='row'>
		            <div class='col-md-12'>
			            <h2 class='title wow fadeInDown' data-wow-offset='200'><span class='subtitle'>{$atts['vehicle_title']}</span></h2>
		            </div>
		            {$this->resolveNavBar($vehicles)}
		            {$this->resolveVehicles($vehicles)}
	            </div>
            </div>  
            <script type='text/javascript'>
                jQuery(document).ready(function ($) {
                    $('.<?php echo $vehicle ?>-data').hide();
                    var activeVehicleData = $('.<?php echo $vehicle ?>-nav .active a').attr('href');
                    $(activeVehicleData).show();
                    $('.<?php echo $vehicle ?>-nav-scroll').click(function () {
                        var topPos = 0;
                        var direction = $(this).data('direction');
                        var scrollHeight = $('.<?php echo $vehicle ?>-nav li').height() + 1;
                        var navHeight = $('#<?php echo $vehicle ?>-nav-container').height() + 1;
                        var actTopPos = $('.<?php echo $vehicle ?>-nav').position().top;
                        var navChildHeight = $('#<?php echo $vehicle ?>-nav-container').find('.<?php echo $vehicle ?>-nav').height();
                        var x = -(navChildHeight - navHeight);
                        var fullHeight = 0;
                        $('.<?php echo $vehicle ?>-nav li').each(function () {
                            fullHeight += scrollHeight;
                        });
                        navHeight = fullHeight - navHeight + scrollHeight;
                        // Scroll Down
                        if ((direction == 'down') && (actTopPos > x) && (-navHeight <= (actTopPos - (scrollHeight * 2)))) {
                            topPos = actTopPos - scrollHeight;
                            $('.<?php echo $vehicle ?>-nav').css('top', topPos);
                        }
                        // Scroll Up
                        if (direction == 'up' && 0 > actTopPos) {
                            topPos = actTopPos + scrollHeight;
                            $('.<?php echo $vehicle ?>-nav').css('top', topPos);
                        }
                        return false;
                    });

                    $('.<?php echo $vehicle ?>-nav li').on('click', function () {

                        $('.<?php echo $vehicle ?>-nav .active').removeClass('active');
                        $(this).addClass('active');

                        $(activeVehicleData).fadeOut('slow', function () {
                            activeVehicleData = $('.<?php echo $vehicle ?>-nav .active a').attr('href');
                            $(activeVehicleData).fadeIn('slow', function () {
                            });
                        });

                        return false;
                    });
                    // Vehicles Responsive Nav
                    //-------------------------------------------------------------
                    var windowWidth = $(window).width();
                    if (windowWidth < 990) {
                        $('<div />').appendTo('.<?php echo $select ?>').addClass('<?php echo $select ?>select-vehicle-data');
                        $('<select />').appendTo('.<?php echo $select ?>').addClass('<?php echo $select ?>-data-select');
                        $('.<?php echo $select ?> a').each(function () {
                            var el = $(this);
                            $('<option />', {
                                'value': el.attr('href'),
                                'text': el.text()
                            }).appendTo('.<?php echo $select ?> select');
                        });
                        $('.<?php echo $select ?>-data-select').change(function () {
                            $(activeVehicleData).fadeOut('slow', function () {
                                activeVehicleData = $('.<?php echo $select ?>-data-select').val();
                                $(activeVehicleData).fadeIn('slow', function () {
                                });
                            });
                            return false;
                        });
                    }
                });
            </script>
        ";
    }
    private function resolveNavBar($vehicles) : string
    {
        return "
            <!-- Vehicle nav start -->
                <div class='col-md-3 vehicle-nav-row wow fadeInUp' data-wow-offset='100'>
                    <div id='hq-vehicle-nav-container' class='vehicle-container'>
                        <ul class='hq-vehicles-inner-nav vehicle-tab-nav'>
                            {$this->resolveNavBarVehicles($vehicles)}
                        </ul>
                    </div>
                    <div class='hq-nav-bar-navigation-nav-control vehicle-scroll hidden-sm'>
                        <a class='hq-nav-bar-navigation-nav-scroll vehicle-scroll' data-direction='up' href='#'><i class='fa fa-chevron-up'></i></a>
                        <a class='hq-nav-bar-navigation-nav-scroll vehicle-scroll' data-direction='down' href='#'><i class='fa fa-chevron-down'></i></a>
                    </div>
                </div>
            <!-- Vehicle nav end -->
        ";
    }
    private function resolveNavBarVehicles($vehicles){
        $html = "";
        if(is_array($vehicles) and count($vehicles)){
            $counter = 1;
            foreach ($vehicles as $vehicle){
                $class = ($counter == 1) ? "class='active'" : '';
                $html .= "
                    <li {$class}>
                        <a href='#{$vehicle->getId()}'>{$vehicle->getLabelForWebsite()}</a><span class='active'>&nbsp;</span>
                    </li>
                ";
                $counter ++;
            }
        }
        return $html;
    }
    private function resolveVehicles($vehicles) : string
    {
        $html = "";
        if(is_array($vehicles) and count($vehicles)){
            foreach ($vehicles as $vehicle) {
                $features = $vehicle->getVehicleFeatures();
                $html .= "
                <!-- Vehicle {$vehicle->getId()} data start -->
                    <div class='vehicle-class-data-{$vehicle->getId()}' id='vehicle-class-{$vehicle->getId()}'>
                        <div class='col-md-6 '>
                            <div class='vehicle-img'>
                                <img class='img-responsive' src='{$vehicle->getPublicImage()}' alt='Vehicle'>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class='vehicle-price'>
                                {$vehicle->getActiveRate()->daily_rate->amount_for_display} <span class='info'> Rent per day</span>
                            </div>
                            <table class='table vehicle-features'>
                                {$this->resolveVehicleFeatures($features)}
                            </table>
                            <a href='#teaser' class='reserve-button scroll-to'><span class='glyphicon glyphicon-calendar'></span>Reserve Now</a>
                        </div>
                    </div>
                <!-- Vehicle {$vehicle->getId()} data end -->
            ";
            }
        }
        return $html;
    }
    private function resolveVehicleFeatures($features)
    {
        $html = "";
        if(is_array($features) and count($features)){
            foreach ($features as $feature){
                $html .= "
                <tr>
                    <td>{$feature->label_for_website->en}</td>
                </tr>
            ";
            }
        }
        return $features;
    }
}
