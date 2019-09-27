<?php

namespace HQRentalsPlugin\HQRentalsModels;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;

class HQRentalsModelsFeature extends HQRentalsBaseModel
{
    /*
     * Custom Post Configuration
     */
    public $featureVehicleClassPostName = 'hqwp_feature';
    public $featureVehicleClassPostSlug = 'features';

    /*
     * HQ Rentals Feature Data
     * Custom Post Metas
     */

    protected $metaVehicleClassId = 'hq_wordpress_feature_vehicle_id_meta';
    protected $metaLabel = 'hq_wordpress_feature_label_meta';
    protected $metaIcon = 'hq_wordpress_feature_icon_meta';

    //Labels per Language
    public $vehicleClassId = '';
    public $label = '';
    public $icon = '';
    public $metaClassId = 'hq_wordpress_feature_vehicle_id_meta';
    public $postID = '';
    public $metaOrderKey = 'hq_wordpress_feature_order_meta';

    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type' => $this->featureVehicleClassPostName,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        if (!empty($post)) {
            $this->setFromPost($post);
        }
    }

    public function setFeatureFromApi($vehicle_id, $data)
    {
        $this->vehicleClassId = $vehicle_id;
        $this->label = $data->label_for_website;
        $this->icon = $data->icon;
    }

    public function create()
    {
        $this->postArgs = array_merge(
            $this->postArgs,
            array(
                'post_title' => (empty($this->label) ? "Feature" : $this->label),
                'post_name' => (empty($this->label) ? "Feature" : $this->label)
            )
        );
        $post_id = wp_insert_post($this->postArgs);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaVehicleClassId, $this->vehicleClassId);
        hq_update_post_meta($post_id, $this->metaLabel, $this->label);
        hq_update_post_meta($post_id, $this->metaIcon, $this->icon);
    }

    public function find($caag_id)
    {
        $query = new \WP_Query($this->postArgs);
    }
    /*
     * Return All Posts
     */
    public function all()
    {
        $query = new \WP_Query($this->postArgs);
        return $query->posts;
    }

    public function setFromPost($post)
    {
        $this->postID = $post->ID;
        foreach ($this->getAllMetaTags() as $property => $metakey) {
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
        }
    }

    public function getAllMetaTags()
    {
        return array(
            'vehicleClassId' => $this->metaVehicleClassId,
            'label' => $this->metaLabel,
            'icon' => $this->metaIcon,
        );
    }

    public function getIcon()
    {
        return HQRentalsFrontHelper::resolveFontAwesomeIcon($this->icon);
    }

}