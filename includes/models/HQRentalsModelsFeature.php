<?php

namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsFeature
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

    protected $metaId = 'hq_wordpress_feature_id_meta';
    protected $metaVehicleClassId = 'hq_wordpress_feature_vehicle_id_meta';
    protected $metaLabel = 'hq_wordpress_feature_label_meta';
    protected $metaIcon = 'hq_wordpress_feature_icon_meta';
    protected $metaOrder = 'hq_wordpress_feature_order_meta';
    //Labels per Languague

    public $id = '';
    public $vehicleClassId = '';
    public $label = '';
    public $icon = '';
    public $order = '';
    public $metaClassId = 'hq_wordpress_feature_vehicle_id_meta';
    public $postID = '';

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
        $this->id = $data->id;
        $this->vehicleClassId = $vehicle_id;
        $this->label = $data->label;
        $this->icon = $data->icon;
        $this->order = $data->order;
    }

    public function create()
    {
        $this->postArgs = array_merge(
            $this->postArgs,
            array(
                'post_title' => $this->label,
                'post_name' => $this->label
            )
        );
        $post_id = wp_insert_post($this->postArgs);
        $this->post_id = $post_id;
        update_post_meta($post_id, $this->metaId, $this->id);
        update_post_meta($post_id, $this->metaVehicleClassId, $this->vehicleClassId);
        update_post_meta($post_id, $this->metaLabel, $this->label);
        update_post_meta($post_id, $this->metaIcon, $this->icon);
        update_post_meta($post_id, $this->metaOrder, $this->order);
    }

    public function update()
    {
        update_post_meta($this->post_id, $this->metaId, $this->id);
        update_post_meta($this->post_id, $this->metaVehicleClassId, $this->vehicleClassId);
        update_post_meta($this->post_id, $this->metaLabel, $this->label);
        update_post_meta($this->post_id, $this->metaIcon, $this->icon);
        update_post_meta($this->post_id, $this->metaOrder, $this->order);
    }

    public function delete()
    {
        delete_post_meta($this->post_id, $this->metaId);
        delete_post_meta($this->post_id, $this->metaVehicleClassId);
        delete_post_meta($this->post_id, $this->metaLabel);
        delete_post_meta($this->post_id, $this->metaIcon);
        delete_post_meta($this->post_id, $this->metaOrder);
        $post_id = wp_delete_post($this->post_id);
    }

    public function find($caag_id)
    {
        $query = new \WP_Query($this->postArgs);
    }

    public function first()
    {
        // TODO: Implement first() method.
    }

    public function set($data)
    {
        if ($this->filter->isPost($data)) {

        } else {
        }
        //$metas =
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
            'id' => $this->metaId,
            'vehicleClassId' => $this->metaVehicleClassId,
            'label' => $this->metaLabel,
            'icon' => $this->metaIcon,
            'order' => $this->metaOrder,
        );
    }

}