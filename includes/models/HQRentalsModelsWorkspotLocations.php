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
    protected $metaAvailable_spots_coordinates_Json = 'hq_wordpress_workspot_available_spots_coordinates_Json_meta';
    protected $metaUnavailable_spots_coordinates_Json = 'hq_wordpress_workspot_unavailable_spots_coordinates_Json_meta';
    protected $metaRented_spots_coordinates_Json = 'hq_wordpress_workspot_rented_spots_coordinates_Json_meta';
    protected $metaAvailable_from_spots_coordinates_Json = 'hq_wordpress_workspot_available_from_spots_coordinates_Json_meta';

    /*
     * Object Data to Display
     */
    public $id = '';
    public $label = '';
    public $uuid = '';
    public $mapUUID = '';
    public $post_id = '';
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
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
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
            'available_spots_coordinates_Json' => $this->metaAvailable_spots_coordinates_Json,
            'unavailable_spots_coordinates_Json' => $this->metaUnavailable_spots_coordinates_Json,
            'rented_spots_coordinates_Json' => $this->metaRented_spots_coordinates_Json,
            'available_from_spots_coordinates_Json' => $this->metaAvailable_from_spots_coordinates_Json
        );
    }

    public function saveDetails($data)
    {
        $prefix = 'https://files-europe.caagcrm.com/tenants/93a9ba46-f29c-4582-a651-25f681c65d9f/files/';
        $spots = array_map(function ($unit) use (&$show_units, $prefix, $data) {
            return [
                'id' => $unit->id,
                'title' => $unit->f353,
                'cover' => $this->resolverSpotCover($unit->f358[0]->uuid, $data, $prefix),
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
        }, $data->units);
        $available_spots_coordinates_Json = caag_init_Json();
        $unavailable_spots_coordinates_Json = caag_init_Json();
        $rented_spots_coordinates_Json = caag_init_Json();
        $available_from_spots_coordinates_Json = caag_init_Json();
        $spots_json = array_map(function ($spot) use (&$available_spots_coordinates_Json, &$unavailable_spots_coordinates_Json, &$rented_spots_coordinates_Json, &$available_from_spots_coordinates_Json) {
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
        $mapUUID = empty($data->f461[0]->uuid) ? '' : ($prefix . $data->f461[0]->uuid . '/redirect');
        hq_update_post_meta($this->post_id, $this->metaAvailable_spots_coordinates_Json, $available_spots_coordinates_Json);
        hq_update_post_meta($this->post_id, $this->metaUnavailable_spots_coordinates_Json, $unavailable_spots_coordinates_Json);
        hq_update_post_meta($this->post_id, $this->metaRented_spots_coordinates_Json, $rented_spots_coordinates_Json);
        hq_update_post_meta($this->post_id, $this->metaAvailable_from_spots_coordinates_Json, $available_from_spots_coordinates_Json);
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
}