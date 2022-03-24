<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

class HQRentalsVehicleGrid
{
    private $linkURL;
    private $title;
    private $brandId;
    private $disableFeatures;
    private $buttonPosition;
    private $wasInit;
    public function __construct($params = null)
    {
        $this->wasInit = !empty($params);
        if($this->wasInit){
            $this->setParams($params);
        }
        add_shortcode('hq_rentals_vehicle_grid', array($this, 'renderShortcode'));
    }

    private function setParams($params)
    {
        if(!empty($params['reservation_url_vehicle_grid'])){
            $this->linkURL = $params['reservation_url_vehicle_grid'];
        }
        if(!empty($params['title_vehicle_grid'])){
            $this->title = $params['title_vehicle_grid'];
        }
        if(!empty($params['brand_id'])){
            $this->brandId = $params['brand_id'];
        }
        if(!empty($params['disable_features_vehicle_grid'])){
            $this->disableFeatures = $params['disable_features_vehicle_grid'];
        }
        if(!empty($params['button_position_vehicle_grid'])){
            $this->buttonPosition = $params['button_position_vehicle_grid'];
        }
    }
    public function renderShortcode($atts = []) : string
    {
        $atts = shortcode_atts(
        array(
            'reservation_url_vehicle_grid' => '',
            'title_vehicle_grid' => '',
            'brand_id' => '',
            'disable_features_vehicle_grid' => '',
            'button_position_vehicle_grid' => ''
        ), $atts);
        if(!$this->wasInit){
            $this->setParams($atts);
        }
        $vehiclesCode = $this->getVehiclesHTML();
        HQRentalsAssetsHandler::loadVehicleGridAssets();
        return '
    ' . HQRentalsAssetsHandler::getHQFontAwesome() . ' 
    <div class="elementor-widget-container hq-elementor-title">
			<h2 class="elementor-heading-title elementor-size-default">' . $this->title . '</h2>		
    </div>
    <div class="elementor-element elementor-widget elementor-widget-html">
        <div class="elementor-widget-container">
            <!-- Begin Loop -->
            ' . $vehiclesCode . '
            <!-- End Loop -->
           
        </div>
    </div>
        ';
    }
    public function getVehiclesHTML()
    {
        $query = new HQRentalsDBQueriesVehicleClasses();
        if($this->brandId){
            $vehicles = $query->getVehiclesByBrand($this->brandId);
        }else{
            $vehicles = $query->allVehicleClasses(true);
        }

        $html = '';
        if (count($vehicles)) {
            $innerHTML = '';
            foreach (array_chunk($vehicles, 3) as $vehiclesRow) {
                $innerHTML .= $this->resolveVehicleRowHTML($vehiclesRow);
            }
            $html .=
                '<div id="hq-smart-vehicle-grid">
                    ' . $innerHTML . '
                </div>';
            return $html;
        }
        return $html;
    }

    public function resolveVehicleRowHTML($vehiclesRow): string
    {
        $html = $this->resolveSingleRowHTML($vehiclesRow);
        return $html;
    }

    public function resolveSingleRowHTML($singleRow): string
    {
        $html = '';
        foreach (array_splice($singleRow, 0, 3) as $vehicle) {
            $html .= $this->resolveSingleVehicleHTML($vehicle);
        }
        return $html;
    }

    public function resolveSingleVehicleHTML($vehicle): string
    {
        if($this->buttonPosition === 'right'){
            $rateTag  = empty($vehicle->getActiveRate()->daily_rate->amount_for_display) ? "" : "<h3>{$vehicle->getActiveRate()->daily_rate->amount_for_display}/Day</h3>";
        }else{
            $rateTag  = "";
        }
        if($this->buttonPosition === 'left'){
            $rateTagLeft  = empty($vehicle->getActiveRate()->daily_rate->amount_for_display) ? "" : "<h3>{$vehicle->getActiveRate()->daily_rate->amount_for_display}/Day</h3>";
        }else{
            $rateTagLeft  = "";
        }

        $html = "
                <div id='hq-vehicle-class-{$vehicle->getId()}' class='vehicle-card'>
                    <div class='hq-list-image-wrapper'>
                        <img class='img-response' src='{$vehicle->getPublicImage()}'>
                    </div>
                    <div class='hq-vehicle-content-wrapper'>
                        <div class='hq-list-label-wrapper-inner'>
                            <h3>{$vehicle->getLabelForWebsite()}</h3>
                            {$rateTag}
                        </div>
                    </div>
                    <div style='width: 100%;'>
                        <div>
                            " . $this->resolveVehicleFeaturesHTML($vehicle) . "    
                        </div>
                        <div class='hq-grid-button-wrapper'>
                            <div class='bottom-info hq-grid-button-wrapper hq-grid-button-wrapper-{$this->buttonPosition}'>
                                <a class='hq-list-rent-button' href='{$this->linkURL}?target_step=3&vehicle_class_id={$vehicle->id}'>RENT NOW</a>
                                {$rateTagLeft}
                            </div>
                        </div>
                    </div>
                </div>
        ";
        return $html;
    }

    public function resolveVehicleFeaturesHTML($vehicle): string
    {
        $html = '';
        if(!($this->disableFeatures === 'yes')){
            $features = $vehicle->getVehicleFeatures();
            if (is_array($features) and count($features)) {
                $html .= "<ul class='list-feature-listing'>";
                foreach ($features as $feature) {
                    $html .= $this->resolveFeatureHTML($feature);
                }
                $html .= "</ul>";
            }
        }
        return $html;
    }

    public function resolveFeatureHTML($feature): string
    {
        $html = "
                <li class='hq-elementor-li'>
                    <span class='icon-wrapper'><i aria-hidden='true' class='{$feature->icon}'></i> </span>
                    <span class='feature-label'>{$feature->label}</span>
                </li>";
        return $html;
    }
}
