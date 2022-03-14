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
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css' integrity='sha512-OtwMKauYE8gmoXusoKzA/wzQoh7WThXJcJVkA29fHP58hBF7osfY0WLCIZbwkeL9OgRCxtAfy17Pn3mndQ4PZQ==' crossorigin='anonymous' referrerpolicy='no-referrer' />
        <script src='https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/l10n/es.min.js' integrity='sha512-qNFoLkoKxYYiUEW14iAJbDcNsfoLTNznoq7UTa5xUp23NmGnlgC/pPWzN5kMcQC4bm+eFx2ibqelc3ARWf+SJw==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/l10n/fr.min.js' integrity='sha512-jV/jfVQ1UsjtjIuGrfA/EdXBPxC2FstPOlyHi281QkuH6hxpgMCDboW2zirI8ErbSQUQmcZBD64x15dHbSKonw==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js' integrity='sha512-+ruHlyki4CepPr07VklkX/KM5NXdD16K1xVwSva5VqOVbsotyCQVKEwdQ1tAeo3UkHCXfSMtKU/mZpKjYqkxZA==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.7/dayjs.min.js' integrity='sha512-bwD3VD/j6ypSSnyjuaURidZksoVx3L1RPvTkleC48SbHCZsemT3VKMD39KknPnH728LLXVMTisESIBOAb5/W0Q==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.7/plugin/customParseFormat.min.js' integrity='sha512-nbPJ/ANJ1DCwUWGyfS+PY7RMysy5UnFyOzPTjzcphOuVbUqrukQAZ9kkNvTkPmItJRuuL5IqNufQTHPyxxpmig==' crossorigin='anonymous' referrerpolicy='no-referrer'></script>
        <style>
            .hq-field-wrapper{
                width: 50% !important;
                flex: 0 0 49% !important;
            }
            .hq-field-wrapper select, .hq-field-wrapper span{
                width:100% !important;
            }
            .hq-field-wrapper select,
            .hq-field-wrapper input, .hq-field-wrapper span,
            .hq-button{
                height: 50px !important;
            }
        </style>
        <div class="elementor-widget-container hq-aucapina-form">
            <form method="GET" action="<?php echo empty($settings['reservation_url_aucapina_form']) ? '/reservations/' : $settings['reservation_url_aucapina_form']; ?>" class="js-filter-form ">

                <div class="l-section l-section--container c-filter c-filter--col-3 c-filter--layout-1"
                     style="color:#ffffff;background-color:#0b4453;">
                    <div class="c-filter__col-1">
                        <div class="c-filter__wrap">
                            <div class="c-filter__field hq-field-wrapper">
                                <div class="c-filter__title">Where?</div>
                                <div class="c-filter__element">
                                    <select name="pick_up_location" id="hq_pick_up_location" class="h-cb c-filter__select styled hasCustomSelect"
                                            style="color: rgba(255, 255, 255, 0.5) !important; background-color: rgb(28, 81, 95) !important; appearance: menulist-button; position: absolute; opacity: 0; height: 50.1875px; font-size: 16px; width: 301px;">
                                        <option value="">Select location</option>
                                        <?php foreach ($locations as $location): ?>
                                            <option value="<?php echo $location->getId(); ?>"><?php echo $location->getLabelForWebsite(); ?></option>
                                        <?php endforeach; ?>
                                    </select><span class="c-custom-select"
                                                   style="color: rgba(255, 255, 255, 0.5) !important; background-color: rgb(28, 81, 95) !important; display: inline-block;"><span
                                                class="c-custom-selectInner"
                                                id="location-tag"
                                                style="width: 301px; display: inline-block;">Select location</span><i
                                                class="ip-select c-custom-select__angle"><!-- --></i></span>
                                </div>
                            </div>

                            <div class="c-filter__field hq-field-wrapper">
                                <div class="c-filter__title">When?</div>
                                <div class="c-filter__element">
                                    <input type="text" class="h-cb c-filter__date " value=""
                                           readonly=""
                                           id="hq-daterange"
                                           style="color:rgba(255, 255, 255, 0.5)!important;background-color:rgb(28, 81, 95)!important;">
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="c-filter__col-2">
                        <button type="submit" class="c-button c-button--fullwidth js-filter-button hq-button">Search</button>
                        <input type="hidden" name="target_step" value="2" />
                        <input type="hidden" name="pick_up_time" value="14:00" />
                        <input type="hidden" name="return_time" value="11:00" />
                        <input type="hidden" name="pick_up_date" id="hq_pick_up_date" value="" />
                        <input type="hidden" name="return_date" id="hq_return_date" value="" />
                        <input type="hidden" name="return_location" id="hq_return_location" value="<?php echo $locations[0]->getId(); ?>">
                    </div>
                </div>
            </form>
        </div>
        <script>
            dayjs.extend(window.dayjs_plugin_customParseFormat);
            jQuery(document).ready(function (){

                var config = {
                    dateFormat: 'd-m-Y',
                    disableMobile: 'true',
                    enableTime: false,
                    mode: "range",
                    onChange: function(data){
                        var pickUpDate = data[0];
                        var returnDate = data[1];
                        jQuery('#hq_pick_up_date').val(parseDateToText(pickUpDate, 'DD-MM-YYYY'));
                        jQuery('#hq_return_date').val(parseDateToText(returnDate, 'DD-MM-YYYY'));
                    }
                };
                var dateFormatMoment = 'DD-MM-YYYY';
                flatpickr('#hq-daterange', config);
                var pickDefault = dayjs().add(1, 'day').add(15,'minute').format(dateFormatMoment)
                var returnDefault = dayjs().add(1, 'day').add(3,'day').add(15,'minute').format(dateFormatMoment);
                jQuery('#hq_pick_up_date').val(pickDefault);
                jQuery('#hq_return_date').val(returnDefault);
                jQuery('#hq-daterange').val(pickDefault + ' to ' + returnDefault);
                jQuery('#hq_pick_up_time').on('change',function(e){
                    jQuery('#hq_return_time').val( jQuery('#hq_pick_up_time').val() );
                });
                jQuery('#hq_pick_up_location').on('change',function(){
                    jQuery('#hq_return_location').val(jQuery('#hq_pick_up_location').val());
                    if(hqRentalsLocations && Array.isArray(hqRentalsLocations)){
                        var locationsFiltered = hqRentalsLocations.filter(function(location){
                            return String(location.id) === String(jQuery('#hq_pick_up_location').val());
                        })
                        jQuery('#location-tag').html(locationsFiltered[0].name);
                    }

                });
                jQuery('#hq_vehicle_class_id').on('change',function(){
                    if(hqRentalsVehicles && Array.isArray(hqRentalsVehicles)){
                        var vehiclesFileteres = hqRentalsVehicles.filter(function(vehicle){
                            return String(vehicle.id) === String(jQuery('#hq_vehicle_class_id').val());
                        })
                        jQuery('#vehicle-tag').html(vehiclesFileteres[0].name);
                    }

                });



            });

            function parseDateToText(date,format){
                var day = dayjs(date);
                return day.format(format);
            }
            function resolveLang(locale){
                if(locale === 'es_ES'){
                    return es.Spanish;
                }
                if(locale === 'fr_CA'){
                    return fr.French;
                }
                return null;
            }
        </script>
        <?php
    }
}

