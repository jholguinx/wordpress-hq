<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsElementor\HQRentalsElementorAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

class HQRentalsVehicleGrid
{
    private $linkURL;
    private $title;
    public function __construct($params)
    {
        if(!empty($params['url'])){
            $this->linkURL = $params['url'];
        }
        if(!empty($params['title'])){
            $this->title = $params['title'];
        }
        add_shortcode('hq_rentals_vehicle_grid', array($this, 'renderShortcode'));
    }

    public function renderShortcode()
    {
        $vehiclesCode = $this->getVehiclesHTML();
        HQRentalsElementorAssetsHandler::loadVehicleGridAssets();
        echo '
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
        $vehicles = $query->allVehicleClasses();
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
        $html =
            '<div id="hq-smart-vehicle-grid-row" class="vehicle-cards-div">
                ' . $this->resolveSingleRowHTML($vehiclesRow) . '
            </div>';
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
        $html = "
                <div id='hq-vehicle-class-{$vehicle->getId()}' class='vehicle-card'>
                    <div class='hq-list-image-wrapper'>
                        <img class='img-response' src='{$vehicle->getPublicImage()}'>
                    </div>
                    <div class='hq-list-label-wrapper'>
                        <h3>{$vehicle->getLabelForWebsite()}</h3>
                    </div>
                    " . $this->resolveVehicleFeaturesHTML($vehicle) . "
                    <div class='bottom-info'>
                        <p><span>{$vehicle->getActiveRate()->daily_rate->amount_for_display}</span>/Day</p>
                        <a class='hq-list-rent-button' href='{$this->linkURL}'>RENT NOW</a>
                    </div>
                </div>
        ";
        return $html;
    }

    public function resolveVehicleFeaturesHTML($vehicle): string
    {
        $features = $vehicle->getVehicleFeatures();
        $html = '';
        if (is_array($features) and count($features)) {
            $html .= "<ul class='list-feature-listing'>";
            foreach ($features as $feature) {
                $html .= $this->resolveFeatureHTML($feature);
            }
            $html .= "</ul>";
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
