<?php
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;

class HQRentalsElementorAucapinaReservationForm extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $this->linkURL = '';
    }

    public function get_name()
    {
        return 'Aucapina - Reservation Form';
    }

    public function get_title()
    {
        return __('Aucapina - Reservation Form', 'hq-wordpress');
    }

    public function get_icon()
    {
        return 'eicon-product-categories';
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
            'reservation_url_aucapina_form',
            [
                'label' => __('Reservations URL', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $locationQuery = new HQRentalsQueriesLocations();
        $vehiclesQuery = new HQRentalsQueriesVehicleClasses();
        $vehicles = $vehiclesQuery->allVehicleClasses();
        $locations = $locationQuery->allLocations();
        ?>
        <div class="elementor-widget-container">
            <form method="GET" action="catalog/" class="js-filter-form ">

                <div class="l-section l-section--container c-filter c-filter--col-3 c-filter--layout-1"
                     style="color:#ffffff;background-color:#0b4453;">
                    <div class="c-filter__col-1">
                        <div class="c-filter__wrap">
                            <div class="c-filter__field">
                                <div class="c-filter__title">Where?</div>
                                <div class="c-filter__element">
                                    <select name="pickup" class="h-cb c-filter__select styled hasCustomSelect"
                                            style="color: rgba(255, 255, 255, 0.5) !important; background-color: rgb(28, 81, 95) !important; appearance: menulist-button; position: absolute; opacity: 0; height: 50.1875px; font-size: 16px; width: 301px;">
                                        <option value="">Select location</option>
                                        <?php foreach ($locations as $location): ?>
                                            <option value="<?php echo $location->getId(); ?>"><?php echo $location->getLabelForWebsite(); ?></option>
                                        <?php endforeach; ?>
                                    </select><span class="c-custom-select"
                                                   style="color: rgba(255, 255, 255, 0.5) !important; background-color: rgb(28, 81, 95) !important; display: inline-block;"><span
                                                class="c-custom-selectInner"
                                                style="width: 301px; display: inline-block;">Select location</span><i
                                                class="ip-select c-custom-select__angle"><!-- --></i></span>
                                </div>
                            </div>

                            <div class="c-filter__field">
                                <div class="c-filter__title">When?</div>
                                <div class="c-filter__element">
                                    <input type="hidden" class="js-filter-date-start " name="start" value="04.04.2022"
                                           data-value="03.03.2022">
                                    <input type="hidden" class="js-filter-date-end " name="end" value="19.04.2022"
                                           data-value="06.03.2022">
                                    <input type="text" class="h-cb c-filter__date js-filter-date-range" value=""
                                           readonly=""
                                           style="color:rgba(255, 255, 255, 0.5)!important;background-color:rgb(28, 81, 95)!important;">
                                </div>
                            </div>

                            <div class="c-filter__field">
                                <div class="c-filter__title">Type?</div>
                                <div class="c-filter__element">
                                    <select class="h-cb c-filter__select styled js-filter-type hasCustomSelect"
                                            style="color: rgba(255, 255, 255, 0.5) !important; background-color: rgb(28, 81, 95) !important; appearance: menulist-button; position: absolute; opacity: 0; height: 50.1875px; font-size: 16px; width: 301px;">
                                        <option value="https://www.benzinicampers.com/catalog/">Select type</option>
                                        <?php foreach ($vehicles as $vehicle): ?>
                                            <option value="<?php echo $vehicle->getId(); ?>"><?php echo $vehicle->getLabelForWebsite(); ?></option>
                                        <?php endforeach;?>
                                    </select><span class="c-custom-select"
                                                   style="color: rgba(255, 255, 255, 0.5) !important; background-color: rgb(28, 81, 95) !important; display: inline-block;"><span
                                                class="c-custom-selectInner"
                                                style="width: 301px; display: inline-block;">Select type</span><i
                                                class="ip-select c-custom-select__angle"><!-- --></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="c-filter__col-2">
                        <button type="submit" class="c-button c-button--fullwidth js-filter-button">Search</button>
                        <input type="hidden" name="target_step" value="2" />
                        <input type="hidden" name="pick_up_time" value="12:00" />
                        <input type="hidden" name="return_time" value="12:00" />
                        <input type="hidden" name="return_location" id="hq-return-location" value="<?php echo $locations[0]->getId(); ?>">
                    </div>
                </div>
            </form>

        </div>
        <?php
    }
}

