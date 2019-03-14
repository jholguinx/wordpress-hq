<?php

namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsVendor\Carbon;

class HQRentalsModelsWorkspotLocations extends HQRentalsBaseModel
{

    /*
     * Custom Post Configuration
     */
    public $locationsCustomPostName = 'hqwp_workspot_loc';
    public $locationsCustomPostSlug = 'workspot-locations';

    /*
     * HQ Rentals Location Data
     * Custom Post Metas
     */

    protected $metaId = 'hq_wordpress_workspot_location_id_meta';
    protected $metaLabel = 'hq_wordpress_workspot_location_label_meta';
    protected $metaUUID = 'hq_wordpress_workspot_location_uuid_meta';
    protected $metaMapUUID = 'hq_wordpress_workspot_location_map_uuid_meta';
    protected $metaHasFloors = 'hq_wordpress_workspot_location_has_floors_meta';
    protected $metaAvailable_spots_coordinates_Json = 'hq_wordpress_workspot_available_spots_coordinates_Json_meta';
    protected $metaUnavailable_spots_coordinates_Json = 'hq_wordpress_workspot_unavailable_spots_coordinates_Json_meta';
    protected $metaRented_spots_coordinates_Json = 'hq_wordpress_workspot_rented_spots_coordinates_Json_meta';
    protected $metaAvailable_from_spots_coordinates_Json = 'hq_wordpress_workspot_available_from_spots_coordinates_Json_meta';
    protected $metaFloors = 'hq_wordpress_workspot_meta_floors_Json_meta';
    /*
     * Object Data to Display
     */
    public $id = '';
    public $label = '';
    public $uuid = '';
    public $mapUUID = '';
    public $post_id = '';
    public $hasFloors = '';
    public $floors = '';
    public $available_spots_coordinates_Json = '';
    public $unavailable_spots_coordinates_Json = '';
    public $rented_spots_coordinates_Json = '';
    public $available_from_spots_coordinates_Json = '';


    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type' => $this->locationsCustomPostName,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $this->labels = array(
            'name' => _x('Locations', 'post type general name', 'hq-wordpress'),
            'singular_name' => _x('Location', 'post type singular name', 'hq-wordpress'),
            'menu_name' => _x('Locations', 'admin menu', 'hq-wordpress'),
            'name_admin_bar' => _x('Location', 'add new on admin bar', 'hq-wordpress'),
            'add_new' => _x('Add New', 'brand', 'hq-wordpress'),
            'add_new_item' => __('Add New Location', 'hq-wordpress'),
            'new_item' => __('New Location', 'hq-wordpress'),
            'edit_item' => __('Edit Location', 'hq-wordpress'),
            'view_item' => __('View Location', 'hq-wordpress'),
            'all_items' => __('All Locations', 'hq-wordpress'),
            'search_items' => __('Search Locations', 'hq-wordpress'),
            'parent_item_colon' => __('Parent Locations', 'hq-wordpress'),
            'not_found' => __('No location found.', 'hq-wordpress'),
            'not_found_in_trash' => __('No location found in Trash.', 'hq-wordpress')
        );
        $this->customPostArgs = array(
            'labels' => $this->labels,
            'public' => false,
            'show_in_admin_bar' => false,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'query_var' => false,
            'rewrite' => array('slug' => $this->locationsCustomPostSlug),
            'has_archive' => false,
            'hierarchical' => false,
            'exclude_from_search' => false,
            'menu_icon' => 'dashicons-location-alt',
            'menu_position' => 7,
            'capabilities' => array(
                'create_posts' => 'do_not_allow'
            )
        );
        if (!empty($post)) {
            $this->setFromPost($post);
        }
    }

    public function setLocationFromApi($data)
    {
        $this->id = $data->id;
        $this->label = $data->label;
        $this->uuid = $data->uuid;
    }


    public function create()
    {
        $this->postArgs = array_merge(
            $this->postArgs,
            array(
                'post_title' => $this->label,
                'post_name' => $this->label,
                'posts_per_page' => -1
            )
        );
        $post_id = wp_insert_post($this->postArgs);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaId, $this->id);
        hq_update_post_meta($post_id, $this->metaLabel, $this->label);
        hq_update_post_meta($post_id, $this->metaUUID, $this->uuid);
    }

    /*
     * Find
     */
    public function find($caag_id)
    {
        $query = new \WP_Query($this->postArgs);
    }

    public function first()
    {
        // TODO: Implement first() method.
    }

    public function all()
    {
        $query = new \WP_Query($this->postArgs);
        return $query->posts;
    }

    public function set($data)
    {
        if ($this->filter->isPost($data)) {

        } else {
        }
        //$metas =
    }

    public function setFromPost($post)
    {
        foreach ($this->getAllMetaTags() as $property => $metakey) {
            if($property === "floors"){
                $this->{$property} = json_decode(get_post_meta($post->ID, $metakey, true));
            }else{
                $this->{$property} = get_post_meta($post->ID, $metakey, true);
            }

        }
        $this->post_id = $post->ID;
    }

    public function getAllMetaTags()
    {
        return array(
            'id' => $this->metaId,
            'label' => $this->metaLabel,
            'uuid' => $this->metaUUID,
            'mapUUID' => $this->metaMapUUID,
            'hasFloors' =>  $this->metaHasFloors,
            'available_spots_coordinates_Json' => $this->metaAvailable_spots_coordinates_Json,
            'unavailable_spots_coordinates_Json' => $this->metaUnavailable_spots_coordinates_Json,
            'rented_spots_coordinates_Json' => $this->metaRented_spots_coordinates_Json,
            'available_from_spots_coordinates_Json' => $this->metaAvailable_from_spots_coordinates_Json,
            'floors'    => $this->metaFloors
        );
    }

    public function saveDetails($data)
    {
        $prefix = 'https://files-europe.caagcrm.com/tenants/93a9ba46-f29c-4582-a651-25f681c65d9f/files/';
        $spots = $this->processSpots($data, $prefix);
        $processSpots = $this->proccessMap($spots, $data, $prefix);
        if(empty($data->floors)){
            hq_update_post_meta($this->post_id, $this->metaHasFloors, 0);
            hq_update_post_meta($this->post_id, $this->metaAvailable_spots_coordinates_Json, $processSpots['available_spots_coordinates_Json']);
            hq_update_post_meta($this->post_id, $this->metaUnavailable_spots_coordinates_Json, $processSpots['unavailable_spots_coordinates_Json']);
            hq_update_post_meta($this->post_id, $this->metaRented_spots_coordinates_Json, $processSpots['rented_spots_coordinates_Json']);
            hq_update_post_meta($this->post_id, $this->metaAvailable_from_spots_coordinates_Json, $processSpots['available_from_spots_coordinates_Json']);
        }else{
            hq_update_post_meta($this->post_id, $this->metaHasFloors, 1);
            hq_update_post_meta($this->post_id, $this->metaFloors, $processSpots);
        }
        $mapUUID = empty($data->f461[0]->uuid) ? '' : ($prefix . $data->f461[0]->uuid . '/redirect');
        hq_update_post_meta($this->post_id, $this->metaMapUUID, $mapUUID);
    }

    /***
     * Gebouw Data Details
     * @param $data
     * @param $floors
     * @param $units
     */
    public function saveDetailsGebouwLocation($data, $floors, $units)
    {
        $prefix = 'https://files-europe.caagcrm.com/tenants/a3b37f43-16d3-4251-9ea3-2cc36cafb7ec/files/';
        $spots = $this->processSpotsForGebouw($units, $prefix, $data);
        $processSpots = $this->proccessMapGebouw($spots, $floors, $prefix);
        hq_update_post_meta($this->post_id, $this->metaHasFloors, 1);
        hq_update_post_meta($this->post_id, $this->metaFloors, $processSpots);
        $mapUUID = empty($data->f461[0]->uuid) ? '' : ($prefix . $data->f461[0]->uuid . '/redirect');
        hq_update_post_meta($this->post_id, $this->metaMapUUID, $mapUUID);
    }

    protected function resolverSpotCover($cover, $details, $prefix)
    {
        if (empty($cover)) {
            return $prefix . $details->f504[0]->uuid . '/redirect';
        } else {
            return $prefix . $cover . '/redirect';
        }
    }
    protected function processSpotsForGebouw($units, $prefix, $details){
        return array_map(function ($unit) use (&$show_units, $prefix, $details) {
            return [
                'id' => $unit->id,
                'title' => $unit->f353,
                'cover' => $this->resolverSpotCover($unit->f358[0]->uuid, $details, $prefix),
                'sticker_label' => $unit->f355,
                'sticker_color' => $unit->f356,
                'coordinates' => $unit->f462,
                'status' => $unit->f453,
                'price' => $unit->f543,
                'unit_number' => $unit->f482 ?? '',
                'website_product' => $unit->website_product->label,
                'product_name' => $unit->product->label,
                'available_date' => $unit->f513 ? Carbon::parse($unit->f513)->format('d-m-Y') : null,
                'show_in_website' => $unit->f501,
                'floor' => $this->id != 20 ? $unit->f1574 : $unit->f1397,
                'location_id' => $this->id
            ];
        }, $units);
    }
    protected function processSpots($details, $prefix)
    {
        if(empty($details->floors)){
            return array_map(function ($unit) use (&$show_units, $prefix, $details) {
                return [
                    'id' => $unit->id,
                    'title' => $unit->f353,
                    'cover' => $this->resolverSpotCover($unit->f358[0]->uuid, $details, $prefix),
                    'sticker_label' => $unit->f355,
                    'sticker_color' => $unit->f356,
                    'coordinates' => $unit->f462,
                    'status' => $unit->f453,
                    'price' => $unit->f543,
                    'unit_number' => $unit->f482 ?? '',
                    'website_product' => $unit->website_product->label,
                    'product_name' => $unit->product->label,
                    'available_date' => $unit->f513 ? Carbon::parse($unit->f513)->format('d-m-Y') : null,
                    'show_in_website' => $unit->f501,
                ];
            }, $details->units);
        }else{
            return array_map(function ($unit) use (&$show_units, $prefix, $details) {
                return [
                    'id' => $unit->id,
                    'title' => $unit->f353,
                    'cover' => $this->resolverSpotCover($unit->f358[0]->uuid, $details, $prefix),
                    'sticker_label' => $unit->f355,
                    'sticker_color' => $unit->f356,
                    'coordinates' => $unit->f462,
                    'status' => $unit->f453,
                    'price' => $unit->f543,
                    'unit_number' => $unit->f482 ?? '',
                    'website_product' => $unit->website_product->label,
                    'product_name' => $unit->product->label,
                    'available_date' => $unit->f513 ? Carbon::parse($unit->f513)->format('d-m-Y') : null,
                    'show_in_website' => $unit->f501,
                    'floor' => $this->id != 20 ? $unit->f1574 : $unit->f1397,
                    'location_id' => $this->id
                ];
            }, $details->units);
        }
    }
    protected function proccessMap($spots, $details, $prefix)
    {
        if(empty($details->floors))
        {
            $available_spots_coordinates_Json = caag_init_Json();
            $unavailable_spots_coordinates_Json = caag_init_Json();
            $rented_spots_coordinates_Json = caag_init_Json();
            $available_from_spots_coordinates_Json = caag_init_Json();
            $spots = array_map(function ($spot) use (&$available_spots_coordinates_Json, &$unavailable_spots_coordinates_Json, &$rented_spots_coordinates_Json, &$available_from_spots_coordinates_Json) {
                switch ($spot['status']) {
                    case 'available':
                        if ($spot['coordinates']) {
                            foreach (json_decode($spot['coordinates'])->features as $feature) {
                                if ($feature->properties) {
                                    $feature->properties->status = 'Beschikbaar';
                                    caag_setFeatureProperties($feature, $spot, $this->post_id);
                                }
                                array_push($available_spots_coordinates_Json->features, $feature);
                            }
                        }
                        break;
                    case 'unavailable':
                        if ($spot['coordinates']) {
                            foreach (json_decode($spot['coordinates'])->features as $feature) {
                                if ($feature->properties) {
                                    $feature->properties->status = 'Algemene Ruimte';
                                    caag_setFeatureProperties($feature, $spot, $this->post_id);
                                }
                                array_push($unavailable_spots_coordinates_Json->features, $feature);
                            }
                        }
                        break;
                    case 'rented':
                        if ($spot['coordinates']) {
                            foreach (json_decode($spot['coordinates'])->features as $feature) {
                                if ($feature->properties) {
                                    $feature->properties->status = 'Verhuurd';
                                    caag_setFeatureProperties($feature, $spot, $this->post_id);
                                }
                                array_push($rented_spots_coordinates_Json->features, $feature);
                            }
                        }
                        break;
                    case 'available_from':
                        if ($spot['coordinates']) {
                            foreach (json_decode($spot['coordinates'])->features as $feature) {
                                if ($feature->properties) {
                                    $feature->properties->status = 'Beschikbaar vanaf';
                                    caag_setFeatureProperties($feature, $spot, $this->post_id);
                                }
                                array_push($available_from_spots_coordinates_Json->features, $feature);
                            }
                        }
                }
            }, $spots);
            $available_spots_coordinates_Json = json_encode($available_spots_coordinates_Json);
            $unavailable_spots_coordinates_Json = json_encode($unavailable_spots_coordinates_Json);
            $rented_spots_coordinates_Json = json_encode($rented_spots_coordinates_Json);
            $available_from_spots_coordinates_Json = json_encode($available_from_spots_coordinates_Json);
            return [
                'available_spots_coordinates_Json'      => $available_spots_coordinates_Json,
                'unavailable_spots_coordinates_Json'    =>  $unavailable_spots_coordinates_Json,
                'rented_spots_coordinates_Json'         =>  $rented_spots_coordinates_Json,
                'available_from_spots_coordinates_Json' =>  $available_from_spots_coordinates_Json
            ];
        }else{
            $processedFloors = [];
            foreach ($details->floors as $floor) {
                $floor->available_spots_coordinates_Json = caag_init_Json();
                $floor->unavailable_spots_coordinates_Json = caag_init_Json();
                $floor->rented_spots_coordinates_Json = caag_init_Json();
                $floor->available_from_spots_coordinates_Json = caag_init_Json();
                $floor->option_spots_coordinates_Json = caag_init_Json();
                $floor->map = $this->resolveMapOnFloors($prefix, $floor);
                array_map(function ($spot) use (&$floor) {
                    if ($spot['floor'] == $floor->id) {
                        switch ($spot['status']) {
                            case 'available':
                                if ($spot['coordinates']) {
                                    foreach (json_decode($spot['coordinates'])->features as $feature) {
                                        if ($feature->properties) {
                                            $feature->properties->status = 'Beschikbaar';
                                            caag_setFeatureProperties($feature, $spot, $this->post_id);
                                        }
                                        array_push($floor->available_spots_coordinates_Json->features, $feature);
                                    }
                                }
                                break;
                            case 'unavailable':
                                if ($spot['coordinates']) {
                                    foreach (json_decode($spot['coordinates'])->features as $feature) {
                                        if ($feature->properties) {
                                            $feature->properties->status = 'Algemene Ruimte';
                                            caag_setFeatureProperties($feature, $spot, $this->post_id);
                                        }
                                        array_push($floor->unavailable_spots_coordinates_Json->features, $feature);
                                    }
                                }
                                break;
                            case 'rented':
                                if ($spot['coordinates']) {
                                    foreach (json_decode($spot['coordinates'])->features as $feature) {
                                        if ($feature->properties) {
                                            $feature->properties->status = 'Verhuurd';
                                            caag_setFeatureProperties($feature, $spot, $this->post_id);
                                        }
                                        array_push($floor->rented_spots_coordinates_Json->features, $feature);
                                    }
                                }
                                break;
                            case 'available_from':
                                if ($spot['coordinates']) {
                                    foreach (json_decode($spot['coordinates'])->features as $feature) {
                                        if ($feature->properties) {
                                            $feature->properties->status = 'Beschikbaar vanaf';
                                            caag_setFeatureProperties($feature, $spot, $this->post_id);
                                        }
                                        array_push($floor->available_from_spots_coordinates_Json->features, $feature);
                                    }
                                }
                                break;
                            case 'option':
                                if ($spot['coordinates']) {
                                    foreach (json_decode($spot['coordinates'])->features as $feature) {
                                        if ($feature->properties) {
                                            $feature->properties->status = 'In Optie';
                                            caag_setFeatureProperties($feature, $spot, $this->post_id);
                                        }
                                        array_push($floor->option_spots_coordinates_Json->features, $feature);
                                    }
                                }
                        }
                    }

                }, $spots);

                $array_key = $this->id != 20 ? 'f1601' : 'f1403';
                $processedFloors[$floor->f1601] = $floor;
                $processedFloors[$floor->f1601]->available_spots_coordinates_Json = json_encode($floor->available_spots_coordinates_Json);
                $processedFloors[$floor->f1601]->unavailable_spots_coordinates_Json = json_encode($floor->unavailable_spots_coordinates_Json);
                $processedFloors[$floor->f1601]->rented_spots_coordinates_Json = json_encode($floor->rented_spots_coordinates_Json);
                $processedFloors[$floor->f1601]->available_from_spots_coordinates_Json = json_encode($floor->available_from_spots_coordinates_Json);
                $processedFloors[$floor->f1601]->option_spots_coordinates_Json = json_encode($floor->option_spots_coordinates_Json);
            }
            return json_encode($processedFloors);
        }
    }
    protected function proccessMapGebouw($spots, $floors, $prefix)
    {
        $processedFloors = [];
        foreach ($floors as $floor) {
            $floor->available_spots_coordinates_Json = caag_init_Json();
            $floor->unavailable_spots_coordinates_Json = caag_init_Json();
            $floor->rented_spots_coordinates_Json = caag_init_Json();
            $floor->available_from_spots_coordinates_Json = caag_init_Json();
            $floor->option_spots_coordinates_Json = caag_init_Json();
            $floor->map = $this->resolveMapOnFloors($prefix, $floor);
            array_map(function ($spot) use (&$floor) {
                if ($spot['floor'] == $floor->id) {
                    switch ($spot['status']) {
                        case 'available':
                            if ($spot['coordinates']) {
                                foreach (json_decode($spot['coordinates'])->features as $feature) {
                                    if ($feature->properties) {
                                        $feature->properties->status = 'Beschikbaar';
                                        caag_setFeatureProperties($feature, $spot, $this->post_id);
                                    }
                                    array_push($floor->available_spots_coordinates_Json->features, $feature);
                                }
                            }
                            break;
                        case 'unavailable':
                            if ($spot['coordinates']) {
                                foreach (json_decode($spot['coordinates'])->features as $feature) {
                                    if ($feature->properties) {
                                        $feature->properties->status = 'Algemene Ruimte';
                                        caag_setFeatureProperties($feature, $spot, $this->post_id);
                                    }
                                    array_push($floor->unavailable_spots_coordinates_Json->features, $feature);
                                }
                            }
                            break;
                        case 'rented':
                            if ($spot['coordinates']) {
                                foreach (json_decode($spot['coordinates'])->features as $feature) {
                                    if ($feature->properties) {
                                        $feature->properties->status = 'Verhuurd';
                                        caag_setFeatureProperties($feature, $spot, $this->post_id);
                                    }
                                    array_push($floor->rented_spots_coordinates_Json->features, $feature);
                                }
                            }
                            break;
                        case 'available_from':
                            if ($spot['coordinates']) {
                                foreach (json_decode($spot['coordinates'])->features as $feature) {
                                    if ($feature->properties) {
                                        $feature->properties->status = 'Beschikbaar vanaf';
                                        caag_setFeatureProperties($feature, $spot, $this->post_id);
                                    }
                                    array_push($floor->available_from_spots_coordinates_Json->features, $feature);
                                }
                            }
                            break;
                        case 'option':
                            if ($spot['coordinates']) {
                                foreach (json_decode($spot['coordinates'])->features as $feature) {
                                    if ($feature->properties) {
                                        $feature->properties->status = 'In Optie';
                                        caag_setFeatureProperties($feature, $spot, $this->post_id);
                                    }
                                    array_push($floor->option_spots_coordinates_Json->features, $feature);
                                }
                            }
                    }
                }

            }, $spots);
            $processedFloors[$floor->f1403] = $floor;
            $processedFloors[$floor->f1403]->available_spots_coordinates_Json = json_encode($floor->available_spots_coordinates_Json);
            $processedFloors[$floor->f1403]->unavailable_spots_coordinates_Json = json_encode($floor->unavailable_spots_coordinates_Json);
            $processedFloors[$floor->f1403]->rented_spots_coordinates_Json = json_encode($floor->rented_spots_coordinates_Json);
            $processedFloors[$floor->f1403]->available_from_spots_coordinates_Json = json_encode($floor->available_from_spots_coordinates_Json);
            $processedFloors[$floor->f1403]->option_spots_coordinates_Json = json_encode($floor->option_spots_coordinates_Json);
        }
        return json_encode($processedFloors);
    }
    protected function resolveMapOnFloors($prefix, $floor)
    {
        if($this->id != 20){
            return empty($floor->f1567[0]->uuid) ? '' : $prefix . $floor->f1567[0]->uuid . '/redirect';
        }else{
            return $prefix . $floor->f1402[0]->uuid . '/redirect';
        }
    }
}