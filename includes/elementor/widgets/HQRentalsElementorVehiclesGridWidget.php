<?php

use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;


class HQRentalsElementorVehiclesGridWidget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'Vehicles Grid';
    }

    public function get_title()
    {
        return __('Vehicles Grid - HQ Rental Software', 'hq-wordpress');
    }

    public function get_icon()
    {
        return 'fab fa-wpforms';
    }

    public function get_categories()
    {
        return ['general'];
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
                'label' => __('URL to Reservation Widget Page', 'hq-wordpress-circle'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('https://your-link.com', 'hq-wordpress-circle'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'hq-wordpress-circle'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'placeholder' => __('HQ RENTAL', 'hq-wordpress-circle'),
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $url = $settings['url'];
        $title = $settings['title'];
        $subtitle = $settings['sub_title'];
        $titleHtml = empty($title) ? "" : '<b>' . $title . '</b> - ';
        $subtitleHtml = empty($subtitle) ? "" : $subtitle;
        $vehiclesCode = $this->getVehiclesHTML();
        echo '
                <link rel="stylesheet" href="https://d1l2ym829b5nxo.cloudfront.net/public/assets/css/fonts.f38c3bc5.css">
    <link rel="stylesheet" href="https://caag.caagcrm.com/assets/font-awesome">
    <div class="elementor-element elementor-widget elementor-widget-html">
        <div class="elementor-widget-container">
            <!-- Begin Loop -->
            ' . $vehiclesCode . '
            <!-- End Loop -->
           
        </div>
    </div>
    <style>
    #hq-smart-vehicle-grid-row{
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        margin-bottom: 50px;
    }
    .vehicle-card{
        width: 30%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: flex-start;
        margin-left: 1.5%;
        margin-right: 1.5%;
    }
    .hq-elementor-li{
        list-style-type: none;
        padding: 0px;
        margin: 0px;
    }
    .hq-elementor-li .feature-label{
        margin-left: 20px;
    }
    .hq-list-image-wrapper{
        justify-content: center;
        display: flex;
        align-items: center;
    }
    .hq-list-label-wrapper{
        justify-content: flex-start;
        display: flex;
        align-items: flex-start;
    }
    .list-feature-listing{
        margin-left: 0px;
        margin-bottom: 20px;
    }
    @media only screen and (max-width: 767px) {
      .vehicle-card{
        width: 100%;
        }
        #hq-smart-vehicle-grid-row{
        display: flex;
        flex-direction: column;
       
        }
    }
    @media only screen and (max-width: 1024px) and (min-width: 768px) {
      body {
        background-color: lightblue;
      }
    }
    </style>
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
                        <a class='small-cta' href='RESERVATION-PAGE'>RENT NOW</a>
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

