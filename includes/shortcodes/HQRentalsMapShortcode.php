<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesWorkspotLocations;

class HQRentalsMapShortcode
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        $this->query = new HQRentalsQueriesWorkspotLocations();
        add_shortcode('hq_rentals_workspot_maps', array($this, 'mapShortcode'));
    }

    public function mapShortcode($atts = [])
    {
        $atts = shortcode_atts(
            array(
                'location_id' => '',
                'floor' => ''
            ), $atts
        );
        $location = $this->query->getLocationById($atts['location_id']);
        wp_localize_script('hq-workspot-sc-script', "hqMapLocationData", [$location]);
        ?>
        <script>
            var locationId = "<?php echo $location->id; ?>";
        </script>
        <h1 id="workspot-location-<?php echo $location->id; ?>" class="section-title style1 text-left">
            <span> <?php echo $location->label; ?> </span></h1>
        <?php if (!empty($location->mapUUID)): ?>
        <div class="location_map_wrap">
            <div id="location-map-<?php echo $location->id; ?>" class="map">
                <!-- map element -->
            </div>
            <div id="popup-<?php echo $location->id; ?>" class="ol-popup">
                <div id="popup-content-<?php echo $location->id; ?>"></div>
            </div>
        </div>
    <?php endif; ?>
        <?php foreach ((array)$location->floors as $key => $floor): ?>
        <?php if (!empty($floor->map) and ($floor->f1569 == 'Yes')): ?>
            <div class="container hq-map-wrapper">
                <div class="wm-page hidden-xs hidden-sm hidden-md"
                     style="max-width: 1080px !important; max-height: 1024px !important;">
                    <div class="location_map_wrap">
                        <h2 class="section-title style1 text-left"><span> <?php echo $floor->label; ?> </span></h2>
                        <div id="location-map-<?php echo $location->id; ?>-<?php echo $key; ?>" class="map">
                            <!-- map element -->
                        </div>
                        <div id="popup-<?php echo $location->id; ?>-<?php echo $key; ?>" class="ol-popup">
                            <div id="popup-content-<?php echo $location->id; ?>-<?php echo $key; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
        <?php
        $this->assets->loadWorkspotAssetsForShortcodes();
    }
}
