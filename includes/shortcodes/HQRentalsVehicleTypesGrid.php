<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsVehicleTypesGrid extends HQRentalsVehicleGrid implements HQShortcodeInterface {
    private $settings;

    public function __construct($params = null)
    {
        $this->queryVehicles = new HQRentalsDBQueriesVehicleClasses();
        $this->settings = new HQRentalsSettings();
        $this->assets = new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_vehicle_types_grid', array($this, 'renderShortcode'));
    }
    public function renderShortcode($atts = []): string
    {
        $atts = shortcode_atts(
            array(
                'reservation_url_vehicle_grid'      => '',
                'title_vehicle_grid'                => '',
                'brand_id'                          => '',
                'disable_features_vehicle_grid'     => '',
                'button_position_vehicle_grid'      => '',
                'button_text'                       => 'RENT NOW',
                'randomize_grid'                    =>  'false',
                'number_of_vehicles'                =>  '',
                'default_dates'                     =>  'false',
                'force_vehicles_by_rate'            =>  'false'
            ), $atts);
        $vehicles = $this->queryVehicles->allVehicleClasses();
        $fields = $this->queryVehicles->getAllCustomFieldsValues();
        HQRentalsAssetsHandler::loadVehicleGridAssets('tabs');
        return HQRentalsAssetsHandler::getHQFontAwesome() . " 
            <div class='elementor-widget-container hq-elementor-title'>
                <h2 class='elementor-heading-title elementor-size-default'>{$atts['title_vehicle_grid']}</h2>		
            </div>
            <div id='hq-tabs'>
                <ul>
                    {$this->resolveTabs($fields)}
                </ul>
                {$this->resolveTabsContent($fields,$vehicles)}
            </div>
        ";
    }
    private function resolveTabs($customFields) : string
    {
        $html = "";
        if(is_array($customFields) and count($customFields)){
            foreach ($customFields as $field) {
                $html .= "<li><a href='#{$field}'>{$field}</a></li>";
            }
        }
        return $html;
    }
    private function resolveTabsContent($fields, $vehicles) : string
    {
        $html = "";
        if(is_array($vehicles) and count($vehicles) and is_array($fields) and count($fields)){
            foreach ($fields as $field){
                $filteredVehicles = array_filter($vehicles, function ($vehicle) use ($field) {
                    return $field == $vehicle->getCustomFieldForWebsite($this->settings->getVehicleClassTypeField());
                });
                $html .= "
                    <div id='{$field}' class='elementor-element elementor-widget elementor-widget-html'>
                    <div class='elementor-widget-container'>
                        <!-- Begin Loop - Tabs -->
                        <div id='hq-smart-vehicle-grid'>
                            {$this->resolveVehicles($filteredVehicles)}  
                        </div>
                        <!-- End Loop - Tabs-->
                    </div>
                </div>
                ";
            }
        }
        return $html;
    }
    private function resolveVehicles($vehicles) : string{
        $html = "";
        foreach ($vehicles as $vehicle){
            $html .= $this->resolveSingleVehicleHTML($vehicle, 'data-custom_field="' . $vehicle->getCustomFieldForWebsite($this->settings->getVehicleClassTypeField()) .'"' );
        }
        return $html;
    }

}