<?php
namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsLocation extends HQRentalsBaseModel
{

    /*
     * Custom Post Configuration
     */
    public $locationsCustomPostName = 'hqwp_locations';
    public $locationsCustomPostSlug = 'location';

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


    /*
     * Object Data to Display
     */
    protected $id = '';
    protected $brandId = '';
    protected $name = '';
    protected $isAirport = '';
    protected $isOffice = '';
    protected $coordinates = '';
    protected $isActive = '';


    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->locationsCustomPostName,
            'post_status'   =>  'publish'
        );
        $this->labels = array(
            'name'               => _x( 'Locations', 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'Location', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'Locations', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'Location', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'brand', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New Location', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New Location', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit Location', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View Location', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All Locations', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search Locations', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent Locations', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No location found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No location found in Trash.', 'your-plugin-textdomain' )
        );
        $this->customPostArgs = array(
            'labels'                    =>  $this->labels,
            'public'                    =>  true,
            'show_in_admin_bar'         =>  true,
            'publicly_queryable'        =>  true,
            'show_ui'                   =>  true,
            'show_in_menu'              =>  true,
            'show_in_nav_menus'         =>  true,
            'query_var'                 =>  true,
            'rewrite'                   =>  array( 'slug' => $this->locationsCustomPostSlug ),
            'has_archive'               =>  true,
            'hierarchical'              =>  false,
            'exclude_from_search'       =>  false,
            'menu_icon'                 => 'dashicons-location-alt',
            'menu_position'             => 7,
            'capability_type'           => 'post'
        );
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
        update_post_meta( $post_id, $this->metaId, $this->id );
        update_post_meta( $post_id, $this->metaBrandId, $this->brandId );
        update_post_meta( $post_id, $this->metaName, $this->name);
        update_post_meta( $post_id, $this->metaAirport, $this->isAirport );
        update_post_meta( $post_id, $this->metaOffice, $this->isOffice );
        update_post_meta( $post_id, $this->metaCoordinates, $this->coordinates );
        update_post_meta( $post_id, $this->metaIsActive, $this->isActive );
    }
    public function update()
    {
        update_post_meta( $this->post_id, $this->metaId, $this->id );
        update_post_meta( $this->post_id, $this->metaBrandId, $this->brandId );
        update_post_meta( $this->post_id, $this->metaName, $this->name);
        update_post_meta( $this->post_id, $this->metaAirport, $this->isAirport );
        update_post_meta( $this->post_id, $this->metaOffice, $this->isOffice );
        update_post_meta( $this->post_id, $this->metaCoordinates, $this->coordinates );
        update_post_meta( $this->post_id, $this->metaIsActive, $this->isActive );
    }

    public function delete()
    {
        delete_post_meta( $this->post_id, $this->metaId );
        delete_post_meta( $this->post_id, $this->metaBrandId );
        delete_post_meta( $this->post_id, $this->metaName );
        delete_post_meta( $this->post_id, $this->metaAirport );
        delete_post_meta( $this->post_id, $this->metaOffice );
        delete_post_meta( $this->post_id, $this->metaCoordinates );
        delete_post_meta( $this->post_id, $this->metaIsActive );
        $post_id = wp_delete_post( $this->post_id , true );
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
}