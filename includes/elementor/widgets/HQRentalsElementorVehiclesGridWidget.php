<?php

use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use \HQRentalsPlugin\HQRentalsElementor\HQRentalsElementorAssetsHandler;
class HQRentalsElementorVehiclesGridWidget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $this->linkURL = '';
    }

    public function get_name()
    {
        return 'Vehicles Grid';
    }

    public function get_title()
    {
        return __('Vehicles Grid', 'hq-wordpress');
    }

    public function get_icon()
    {
        return 'fas fa-grip-horizontal';
    }

    public function get_categories()
    {
        return ['hq-rental-software'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'hq-wordpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'url',
            [
                'label' => __('Reservations URL', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->linkURL = $settings['url'];
        $vehiclesCode = $this->getVehiclesHTML();
        HQRentalsElementorAssetsHandler::loadVehicleGridAssets();
        echo '
    '. HQRentalsAssetsHandler::getHQFontAwesome() .' 
    <div class="elementor-widget-container hq-elementor-title">
			<h2 class="elementor-heading-title elementor-size-default">' . $settings["title"] . '</h2>		
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

