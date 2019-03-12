<?php
namespace HQRentalsPlugin\HQRentalsModels;

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
    /*
     * Object Data to Display
     */
    public $id = '';
    public $label = '';
    public $uuid = '';
    public $post_id = '';



    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'         =>  $this->locationsCustomPostName,
            'post_status'       =>  'publish',
            'posts_per_page'    =>  -1
        );
        $this->labels = array(
            'name'               => _x( 'Locations', 'post type general name', 'hq-wordpress' ),
            'singular_name'      => _x( 'Location', 'post type singular name', 'hq-wordpress' ),
            'menu_name'          => _x( 'Locations', 'admin menu', 'hq-wordpress' ),
            'name_admin_bar'     => _x( 'Location', 'add new on admin bar', 'hq-wordpress' ),
            'add_new'            => _x( 'Add New', 'brand', 'hq-wordpress' ),
            'add_new_item'       => __( 'Add New Location', 'hq-wordpress' ),
            'new_item'           => __( 'New Location', 'hq-wordpress' ),
            'edit_item'          => __( 'Edit Location', 'hq-wordpress' ),
            'view_item'          => __( 'View Location', 'hq-wordpress' ),
            'all_items'          => __( 'All Locations', 'hq-wordpress' ),
            'search_items'       => __( 'Search Locations', 'hq-wordpress' ),
            'parent_item_colon'  => __( 'Parent Locations', 'hq-wordpress' ),
            'not_found'          => __( 'No location found.', 'hq-wordpress' ),
            'not_found_in_trash' => __( 'No location found in Trash.', 'hq-wordpress' )
        );
        $this->customPostArgs = array(
            'labels'                    =>  $this->labels,
            'public'                    =>  false,
            'show_in_admin_bar'         =>  false,
            'publicly_queryable'        =>  false,
            'show_ui'                   =>  false,
            'show_in_menu'              =>  false,
            'show_in_nav_menus'         =>  false,
            'query_var'                 =>  false,
            'rewrite'                   =>  array( 'slug' => $this->locationsCustomPostSlug ),
            'has_archive'               =>  false,
            'hierarchical'              =>  false,
            'exclude_from_search'       =>  false,
            'menu_icon'                 => 'dashicons-location-alt',
            'menu_position'             => 7,
            'capabilities'              => array(
                'create_posts' => 'do_not_allow'
            )
        );
        if(!empty($post)){
            $this->setFromPost($post);
        }
    }
    public function setLocationFromApi($data)
    {
        $this->id = $data->id;
        $this->label = $data->label;
        $this->uuid = $data->uuid;
    }


    public function create( )
    {
        $this->postArgs = array_merge(
            $this->postArgs,
            array(
                'post_title'    =>  $this->name,
                'post_name'     =>  $this->name
            )
        );
        $post_id = wp_insert_post($this->postArgs);
        $this->post_id = $post_id;
        hq_update_post_meta( $post_id, $this->metaId, $this->id );
        hq_update_post_meta( $post_id, $this->metaLabel, $this->label );
        hq_update_post_meta( $post_id, $this->metaUUID, $this->uuid );
    }

    /*
     * Find
     */
    public function find($caag_id)
    {
        $query = new \WP_Query( $this->postArgs );
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
        if($this->filter->isPost($data)){

        }else{}
        //$metas =
    }
    public function setFromPost($post)
    {
        foreach ($this->getAllMetaTags() as $property   =>   $metakey){
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
        }
    }

    public function getAllMetaTags()
    {
        return array(
            'id'            =>  $this->metaId,
            'label'         =>  $this->metaLabel,
            'uuid'          =>  $this->metaUUID

        );
    }

    public function saveDetails($data)
    {
        dd($data);
    }
}