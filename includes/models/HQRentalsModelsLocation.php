<?php
namespace HQRentalsPlugin\HQRentalsModels;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsModelsLocation extends HQRentalsBaseModel
{

    /*
     * Custom Post Configuration
     */
    public $locationsCustomPostName = 'hqwp_locations';
    public $locationsCustomPostSlug = 'locations';

    /*
     * HQ Rentals Location Data
     * Custom Post Metas
     */

    protected $metaId = 'hq_wordpress_location_id_meta';
    protected $metaBrandId = 'hq_wordpress_location_brand_id_meta';
    protected $metaName = 'hq_wordpress_location_name_meta';
    protected $metaAirport = 'hq_wordpress_location_is_airport_meta';
    protected $metaOffice = 'hq_wordpress_location_is_office_meta';
    protected $metaCoordinates = 'hq_wordpress_location_coordinates_meta';
    protected $metaIsActive = 'hq_wordpress_location_is_active_meta';
    protected $metaOrder = 'hq_wordpress_location_order_meta';

    /*
     * Object Data to Display
     */
    public $id = '';
    public $brandId = '';
    public $name = '';
    public $isAirport = '';
    public $isOffice = '';
    public $coordinates = '';
    public $isActive = '';
    public $order = '';


    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->settings = new HQRentalsSettings();
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
            'show_in_admin_bar'         =>  true,
            'publicly_queryable'        =>  true,
            'show_ui'                   =>  true,
            'show_in_menu'              =>  true,
            'show_in_nav_menus'         =>  true,
            'query_var'                 =>  true,
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
        $this->brandId = $data->brand_id;
        $this->name = $data->name;
        $this->isAirport = $data->is_airport;
        $this->isOffice = $data->is_office;
        $this->coordinates = $data->coordinates;
        $this->isActive = $data->active;
        $this->order = $data->order;
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
        hq_update_post_meta( $post_id, $this->metaBrandId, $this->brandId );
        hq_update_post_meta( $post_id, $this->metaName, $this->name);
        hq_update_post_meta( $post_id, $this->metaAirport, $this->isAirport );
        hq_update_post_meta( $post_id, $this->metaOffice, $this->isOffice );
        hq_update_post_meta( $post_id, $this->metaCoordinates, $this->coordinates );
        hq_update_post_meta( $post_id, $this->metaIsActive, $this->isActive );
        hq_update_post_meta( $post_id, $this->metaOrder, $this->order );
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
        $args = array_merge(
            $this->postArgs,
            array(
                'meta_key'   =>  $this->metaOrder,
                'orderby'    =>  'meta_value_num',
                'order'      =>  'ASC',
            ),
            array(
                'meta_query'    =>  array(
                    array(
                        'key'     => $this->metaIsActive,
                        'value'   => '1',
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
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
            'brandId'       =>  $this->metaBrandId,
            'name'          =>  $this->metaName,
            'isAirport'     =>  $this->metaAirport,
            'isOffice'      =>  $this->metaOffice,
            'coordinates'   =>  $this->metaCoordinates,
            'isActive'      =>  $this->metaIsActive,
            'order'         =>  $this->metaOrder
        );
    }
    public function getMetaKeyFromBrandID()
    {
        return $this->metaBrandId;
    }
    public function getBrandId(){
        return $this->brandId;
    }
}