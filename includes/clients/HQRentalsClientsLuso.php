<?php
/**
 * Luso Integration Custom Integration
 */
namespace HQRentalsClients;

class HQRentalsClientsLuso{


    public function getReservationPageFromBrandPage($brand_id, $vehicle_id)
    {
        switch($brand_id){
            case '1':
                return home_url() . '/reservations-honolulu/?vehicle_class_id=' . $vehicle_id;
            case '2':
                return home_url() . '/reservations-san-diego/?vehicle_class_id=' . $vehicle_id;
            case '3':
                return home_url() . '/reservations-las-vegas/?vehicle_class_id=' . $vehicle_id;
            case '4':
                return home_url() . '/reservations-reno-tahoe/?vehicle_class_id=' . $vehicle_id;
            case '5':
                return home_url() . '/reservations-phoenix/?vehicle_class_id=' . $vehicle_id;
            default:
                return home_url() . '/reservations-san-diego/?vehicle_class_id=' . $vehicle_id;
        }
    }
    public function getReservationPageFromBrandPageOnly($brand_id)
    {
        switch($brand_id){
            case '1':
                return home_url() . '/reservations-honolulu/';
            case '2':
                return home_url() . '/reservations-san-diego/';
            case '3':
                return home_url() . '/reservations-las-vegas/';
            case '4':
                return home_url() . '/reservations-reno-tahoe/';
            case '5':
                return home_url() . '/reservations-phoenix/';
            default:
                return home_url() . '/reservations-san-diego/';
        }
    }

    public function getBrandsPageBannerImage($brand_id, $make)
    {
        switch($brand_id){
            case '1':
                //Honolulu
                switch($make){
                    case 'Alfa Romeo':
                        return get_field('honolulu_banner_alfa_romero',4969);
                    case 'Bmw':
                        return get_field('honolulu_banner_bmw',4969);
                    case 'Fiat':
                        return get_field('honolulu_banner_fiat',4969);
                    case 'Ford':
                        return get_field('honolulu_banner_ford',4969);
                    case 'Honda':
                        return get_field('honolulu_banner_honda',4969);
                    case 'Infiniti':
                        return get_field('honolulu_banner_infiniti',4969);
                    case 'Jeep':
                        return get_field('honolulu_banner_jeep',4969);
                    case 'Land Rover Range Rover':
                        return get_field('honolulu_banner_land_rover_range_rover',4969);
                    case 'Toyota':
                        return get_field('honolulu_banner_toyota',4969);
                    case 'Volkswagen':
                        return get_field('honolulu_banner_volkswagen',4969);
                    default:
                        return get_field('honolulu_banner_image',4969);
                }
            case '2':
                //San Diego
                switch($make){
                    case 'Acura':
                        return get_field('san_diego_banner_acura',4963);
                    case 'Alfa Romeo':
                        return get_field('san_diego_banner_alfa_romeo',4963);
                    case 'Audi':
                        return get_field('san_diego_banner_audi',4963);
                    case 'Bmw':
                        return get_field('san_diego_banner_bmw',4963);
                    case 'Cadillac':
                        return get_field('san_diego_banner_cadillac',4963);
                    case 'Chevrolet':
                        return get_field('san_diego_banner_chevrolet',4963);
                    case 'Dodge':
                        return get_field('san_diego_banner_dodge',4963);
                    case 'Fiat':
                        return get_field('san_diego_banner_fiat',4963);
                    case 'Ford':
                        return get_field('san_diego_banner_ford',4963);
                    case 'Gmc':
                        return get_field('san_diego_banner_gmc',4963);
                    case 'Honda':
                        return get_field('san_diego_banner_honda',4963);
                    case 'Hyundai':
                        return get_field('san_diego_banner_hyundai',4963);
                    case 'Infiniti':
                        return get_field('san_diego_banner_infinity',4963);
                    case 'Jaguar':
                        return get_field('san_diego_banner_jaguar',4963);
                    case 'Jeep':
                        return get_field('san_diego_banner_jeep',4963);
                    case 'Kia':
                        return get_field('san_diego_banner_kia',4963);
                    case 'Land Rover':
                        return get_field('san_diego_banner_land_rover',4963);
                    case 'Land Rover Range Rover':
                        return get_field('san_diego_banner_land_rover_range_rover',4963);
                    case 'Lexus':
                        return get_field('san_diego_banner_lexus',4963);
                    case 'Maserati':
                        return get_field('san_diego_banner_maserati',4963);
                    case 'Mercedes-benz':
                        return get_field('san_diego_banner_mercedez_benz',4963);
                    case 'Mini':
                        return get_field('san_diego_banner_mini',4963);
                    case 'Porsche':
                        return get_field('san_diego_banner_porsche',4963);
                    case 'Toyota':
                        return get_field('san_diego_banner_toyota',4963);
                    case 'Volkswagen':
                        return get_field('san_diego_banner_wolkswagen',4963);
                    case 'Volvo':
                        return get_field('san_diego_banner_volvo',4963);
                    default:
                        return get_field('san_diego_banner_image',4963);
                }
            case '3':
                //Las Vegas
                switch($make){
                    case 'Audi':
                        return get_field('las_vegas_banner_image',4966);
                    case 'Bmw':
                        return get_field('las_vegas_banner_bmw',4966);
                    case 'Dodge':
                        return get_field('las_vegas_banner_dodge',4966);
                    case 'Gmc':
                        return get_field('las_vegas_banner_gmc',4966);
                    case 'Infiniti':
                        return get_field('las_vegas_banner_infiniti',4966);
                    case 'Jeep':
                        return get_field('las_vegas_banner_jeep',4966);
                    case 'Lexus':
                        return get_field('las_vegas_banner_lexus',4966);
                    case 'Porsche':
                        return get_field('las_vegas_banner_porsche',4966);
                    default:
                        return get_field('las_vegas_banner_image',4966);
                }

            case '4':
                //Reno
                switch($make){
                    case 'Audi':
                        return get_field('reno_tahoe_banner_audi',4972);
                    case 'Bmw':
                        return get_field('reno_tahoe_banner_bmw',4972);
                    case 'Gmc':
                        return get_field('reno_tahoe_banner_gmc',4972);
                    case 'Land Rover Range Rover':
                        return get_field('reno_tahoe_banner_Land_rover_range_rover',4972);
                    case 'Mercedes-benz':
                        return get_field('reno_tahoe_banner_mercedez_benz',4972);
                    case 'Porsche':
                        return get_field('reno_tahoe_banner_porsche',4972);
                    case 'Toyota':
                        return get_field('reno_tahoe_banner_toyota',4972);
                    default:
                        return get_field('reno_tahoe_banner_image',4972);

                }
            case '5':
                //Phoenix
                switch($make){
                    case 'Infiniti':
                        return get_field('phoenix_banner_infiniti',9342);
                    case 'Kia':
                        return get_field('phoenix_banner_kia',9342);
                    case 'Lexus':
                        return get_field('phoenix_banner_lexus',9342);
                    case 'Mini':
                        return get_field('phoenix_banner_mini',9342);
                    case 'Nissan':
                        return get_field('phoenix_banner_nissan',9342);
                    case 'Volkswagen':
                        return get_field('phoenix_banner_volkswagen',9342);
                    default:
                        return get_field('phoenix_banner_image',9342);
                }
            default:
                return get_field('san_diego_banner_image',4963);
        }
    }
    /***
     *
     *
     *
     */
    function caag_hq_get_all_brands_for_menu_items()
    {
        $brands = caag_hq_get_brands_for_display();
        $return_data = array();
        foreach ( $brands as $brand ){
            $newData = new stdClass();
            $newData->brand_id = $brand->id;
            $newData->brand_name = $brand->name;
            $newData->brand_page = $brand->page_link;
            $makes = [];
            $vehicles_classes = caag_hq_get_vehicle_classes_for_display_by_brand_id( $brand->id );
            foreach ($vehicles_classes as $vehicle){
                if(! in_array($vehicle->f215, $makes) ){
                    $makes[] = $vehicle->f215;
                }
            }
            $newData->makes = custom_sort( $makes );
            $return_data[$brand->id] = $newData;
        }
        return $return_data;
    }
    /*
     * Menu Items
     * */
    public function getMenuItems()
    {
        $brands = caag_hq_get_brands_for_display();
        $return_data = array();
        foreach ( $brands as $brand ){
            $newData = new stdClass();
            $newData->brandId = $brand->id;
            $newData->brandName = $brand->name;
            $classes = caag_hq_get_vehicle_classes_for_display_by_brand_id($brand->id);
            $returnClasses = array();
            foreach ( $classes as $class ){
                $newClass = new stdClass();
                $newClass->id = $class->id;
                $newClass->name = $class->name;
                $returnClasses[] = $newClass;
            }
            $newData->classes = $returnClasses;
            $return_data[]= $newData;
        }
        return $return_data;
    }

    public function getAllTypesItems()
    {
        $brands = caag_hq_get_brands_for_display();
        $return_data = array();
        foreach ( $brands as $brand ){
            $newData = new stdClass();
            $newData->brand_id = $brand->id;
            $types = [];
            $vehicles_classes = caag_hq_get_vehicle_classes_for_display_by_brand_id( $brand->id );
            foreach ($vehicles_classes as $vehicle){
                if(! in_array($vehicle->f225, $types) and !(empty($vehicle->f225)) ){
                    $types[] = $vehicle->f225;
                }
            }
            $newData->types = custom_sort( $types );
            $return_data[$brand->id] = $newData;
        }
        return $return_data;
    }

    public function getMakesByBrands($brand_id, $current_page)
    {
        $vehicles_classes = caag_hq_get_vehicle_classes_for_display_by_brand_id( $brand_id );
        $makes = array();
        $data_return = array();
        foreach ($vehicles_classes as $vehicle) {
            if (!in_array($vehicle->f215, $makes)) {
                $makes[] = $vehicle->f215;
                $new_data = new stdClass();
                $new_data->make = $vehicle->f215;
                $new_data->urlFilter = $current_page . '?brand_id=' . $brand_id . '&make=' . $vehicle->f215;
                $data_return[] = $new_data;
            }
        }
        usort($data_return, "caag_hq_order_by_make");
        return $data_return;
    }

    public function getMakesByBrandsId($brand_id)
    {
        $vehicles_classes = caag_hq_get_vehicle_classes_for_display_by_brand_id( $brand_id );
        $makes = array();
        foreach ($vehicles_classes as $vehicle) {
            if (!in_array($vehicle->f215, $makes)) {
                $makes[] = $vehicle->f215;
            }
        }
        return custom_sort( $makes );
    }

    function getTypesByBrandId($brand_id)
    {
        $vehicles_classes = caag_hq_get_vehicle_classes_for_display_by_brand_id( $brand_id );
        $types = array();
        foreach ($vehicles_classes as $vehicle) {
            if (!in_array($vehicle->f225, $types) and !(empty($vehicle->f225))) {
                $types[] = $vehicle->f225;
            }
        }
        return custom_sort( $types );
    }


    function getOrderByMake($a, $b)
    {
        return strcmp($a->make, $b->make);
    }

    function getCustomSort( $array )
    {
        sort($array);
        return $array;
    }

    /*
     * Filter By Brand - Type - Make
     */
    function getVehicleClassesWithGlobalFilter( $caag_brand_id, $make, $type )
    {
        $args = array(
            'post_type'         =>  CAAG_HQ_RENTAL_CUSTOM_POST_VEHICLE_CLASSES,
            'post_status'       =>  'publish',
            'posts_per_page'    =>  -1,
            'meta_query'        =>  array(
                'key'       =>  CAAG_HQ_RENTAL_VEHICLE_CLASS_BRAND_ID_META,
                'value'     =>  $caag_brand_id,
                'compare'   =>  '='
            )
        );

        $query = new WP_Query( $args );
        $vehicles = array();
        foreach( $query->posts as $vehicle ){
            $new_vehicle = new stdClass();
            $new_vehicle->id = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ID_META, true );
            $new_vehicle->post_id = $vehicle->ID;
            $new_vehicle->brand_id = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_BRAND_ID_META, true );
            $new_vehicle->name = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_NAME_META, true );
            $new_vehicle->active = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_META, true );
            $new_vehicle->recommended = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_RECOMENDED_META, true );
            $new_vehicle->label_en = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_LABEL_FOR_WEBSITE_EN_META, true );
            $new_vehicle->short_description_en = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_SHORT_DESCRIPTION_FOR_WEBSITE_EN_META, true );
            $new_vehicle->description_en = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_DESCRIPTION_FOR_WEBSITE_EN_META, true );
            $new_vehicle->label_nl = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_LABEL_FOR_WEBSITE_NL_META, true );
            $new_vehicle->short_description_nl = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_SHORT_DESCRIPTION_FOR_WEBSITE_NL_META, true );
            $new_vehicle->description_nl = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_DESCRIPTION_FOR_WEBSITE_NL_META, true );
            $new_vehicle->label_de = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_LABEL_FOR_WEBSITE_DE_META, true );
            $new_vehicle->short_description_de = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_SHORT_DESCRIPTION_FOR_WEBSITE_DE_META, true );
            $new_vehicle->description_de = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_DESCRIPTION_FOR_WEBSITE_DE_META, true );
            $new_vehicle->image_link = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_IMAGE_LINK_META, true );
            $new_vehicle->image_link_extension = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_IMAGE_EXTENSION_META, true );
            $new_vehicle->active_rate_id = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_ID_META, true );
            $new_vehicle->active_rate_season_id = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_SEASON_ID_META, true );
            $new_vehicle->base_rate = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_BASE_RATE_META, true );
            $new_vehicle->hourly_rate = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_HOURLY_RATE_META, true );
            $new_vehicle->daily_rate = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_DAILY_RATE_META, true );
            $new_vehicle->weekly_rate = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_WEEKLY_RATE_META, true );
            $new_vehicle->monthly_rate = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_MONTHLY_RATE_META, true );
            $new_vehicle->base_rate_plus_tax = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_BASE_RATE_PLUS_TAX_META, true );
            $new_vehicle->hourly_rate_plus_tax = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_HOURLY_RATE_PLUS_TAX_META, true );
            $new_vehicle->daily_rate_plus_tax = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_DAILY_RATE_PLUS_TAX_META, true );
            $new_vehicle->weekly_rate_plus_tax = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_WEEKLY_RATE_PLUS_TAX_META, true );
            $new_vehicle->monthly_rate_plus_tax = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_MONTHLY_RATE_PLUS_TAX_META, true );
            $new_vehicle->inb_de = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F214_META, true );
            $new_vehicle->f215 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F215_META, true );
            $new_vehicle->f216 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F216_META, true );
            $new_vehicle->f217 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F217_META, true );
            $new_vehicle->f218 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F218_META, true );
            $new_vehicle->f219 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F219_META, true );
            $new_vehicle->f220 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F220_META, true );
            $new_vehicle->f221 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F221_META, true );
            $new_vehicle->f225 = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F225_META, true );
            $new_vehicle->passengers = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F222_META, true );
            $new_vehicle->tech_nl = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F226_META, true );
            $new_vehicle->inb_nl = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F227_META, true );
            $new_vehicle->rating = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_CUSTOM_FIELD_F235_META, true );
            $new_vehicle->decreasing_rate_based_on_intervals = get_post_meta( $vehicle->ID, CAAG_HQ_RENTAL_VEHICLE_CLASS_ACTIVE_RATE_DECREASING_RATES_BASED_ON_INTERVALS_META, true );
            if(($new_vehicle->f215 === $make) and ($new_vehicle->f225 === $type)){
                $vehicles[] = $new_vehicle;
            }
        }
        return $vehicles;
    }

}