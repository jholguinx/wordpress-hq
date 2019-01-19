<?php
namespace HQRentalsPlugin\HQRentalsModels;

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
            'brandId'       =>  $this->brandId,
            'name'          =>  $this->metaName,
            'isAirport'     =>  $this->metaAirport,
            'isOffice'      =>  $this->metaOffice,
            'coordinates'   =>  $this->metaCoordinates,
            'isActive'      =>  $this->metaIsActive
        );
    }
}