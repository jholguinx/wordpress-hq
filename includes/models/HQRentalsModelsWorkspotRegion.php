<?php

namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsWorkspotRegion extends HQRentalsBaseModel
{

    /*
     * Custom Post Configuration
     */
    public $regionsCustomPostName = 'hqwp_workspot_reg';
    public $regionsCustomPostSlug = 'workspot-region';

    /*
     * HQ Rentals Location Data
     * Custom Post Metas
     */

    protected $metaId = 'hq_wordpress_workspot_region_id_meta';
    protected $metaLabel = 'hq_wordpress_workspot_region_label_meta';
    /*
     * Object Data to Display
     */
    public $id = '';
    public $label = '';
    public $post_id = '';

    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type' => $this->regionsCustomPostName,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        $this->customPostArgs = array(
            'public' => false,
            'show_in_admin_bar' => false,
            'publicly_queryable' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'query_var' => false,
            'rewrite' => array('slug' => $this->regionsCustomPostSlug),
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

    public function setRegionFromApi($data)
    {
        $this->id = $data->id;
        $this->label = $data->label;
    }


    public function create()
    {
        $args = array_merge(
            $this->postArgs,
            array(
                'post_title' => $this->label,
                'post_name' => $this->label,
                'posts_per_page' => -1
            )
        );
        $post_id = wp_insert_post($args);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaId, $this->id);
        hq_update_post_meta($post_id, $this->metaLabel, $this->label);
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
        );
    }
}