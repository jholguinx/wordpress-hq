<?php
namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsModels\HQRentalsBaseModel;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDataFilter;

class HQRentalsModelsBrand extends HQRentalsBaseModel{

    /*
     * Custom Post Configuration
     */
    public $brandsCustomPostName = 'hqwp_brands';
    public $brandsCustomPostSlug = 'brands';

    /*
     * HQ Rentals Brand Data
     * Custom Post Metas
     */
    protected $metaId = 'hq_wordpress_brand_id_meta';
    protected $metaName = 'hq_wordpress_brand_name_meta';
    protected $metaTaxLabel = 'hq_wordpress_brand_tax_label_meta';
    protected $metaWebsiteLink = 'hq_wordpress_brand_website_link_meta';
    protected $metaPublicReservationsLinkFull = 'hq_wordpress_brand_public_reservations_link_full';
    protected $metaPublicPackagesLinkFull = 'hq_wordpress_brand_public_packages_link_full';
    protected $metaPublicReservationsFirstStepLink = 'hq_wordpress_brand_public_reservations_first_step_link';
    protected $metaPublicPackagesFirstStepLink = 'hq_wordpress_brand_public_packages_first_step_link';
    protected $metaPublicReservationPackagesFirstStepLink = 'hq_wordpress_brand_public_reservation_packages_first_step_link';
    protected $metaMyReservationsLink = 'hq_wordpress_brand_my_reservation_link';
    protected $metaMyPackagesReservationsLink = 'hq_wordpress_brand_my_packages_reservation_link';
    protected $metaPublicCalendarLink = 'hq_wordpress_brand_public_calendar_link';

    /*
     * Object Data to Display
     */
    public $id = '';
    public $name = '';
    public $taxLabel = '';
    public $websiteLink = '';
    public $publicReservationsLinkFull = '';
    public $publicPackagesLinkFull = '';
    public $publicReservationsFirstStepLink = '';
    public $publicPackagesFirstStepLink = '';
    public $publicReservationPackagesFirstStepLink = '';
    public $myReservationsLink = '';
    public $myPackagesReservationsLink = '';
    public $publicCalendarLink = '';

    /*
     * Constructor
     */
    public function __construct( $post = null )
    {
        $this->post_id = '';
        if ($post) {
	        $this->systemId = $post->ID;
        }
        $this->postArgs = array(
            'post_type'         =>  $this->brandsCustomPostName,
            'post_status'       =>  'publish',
            'posts_per_page'    =>  -1
        );
        $this->labels = array(
            'name'               => _x( 'Brands', 'post type general name', 'your-plugin-textdomain' ),
            'singular_name'      => _x( 'Brand', 'post type singular name', 'your-plugin-textdomain' ),
            'menu_name'          => _x( 'Brands', 'admin menu', 'your-plugin-textdomain' ),
            'name_admin_bar'     => _x( 'Brand', 'add new on admin bar', 'your-plugin-textdomain' ),
            'add_new'            => _x( 'Add New', 'brand', 'your-plugin-textdomain' ),
            'add_new_item'       => __( 'Add New Brand', 'your-plugin-textdomain' ),
            'new_item'           => __( 'New Brand', 'your-plugin-textdomain' ),
            'edit_item'          => __( 'Edit Brand', 'your-plugin-textdomain' ),
            'view_item'          => __( 'View Brand', 'your-plugin-textdomain' ),
            'all_items'          => __( 'All Brands', 'your-plugin-textdomain' ),
            'search_items'       => __( 'Search Brands', 'your-plugin-textdomain' ),
            'parent_item_colon'  => __( 'Parent Brands', 'your-plugin-textdomain' ),
            'not_found'          => __( 'No brands found.', 'your-plugin-textdomain' ),
            'not_found_in_trash' => __( 'No brands found in Trash.', 'your-plugin-textdomain' )
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
            'rewrite'                   =>  array( 'slug' => $this->brandsCustomPostSlug ),
            'has_archive'               =>  true,
            'hierarchical'              =>  false,
            'exclude_from_search'       =>  false,
            'menu_icon'                 => 'dashicons-store',
            'menu_position'             => 6,
            'capabilities'              => array(
                'create_posts' => 'do_not_allow'
            )
        );
        $this->filter = new HQRentalsDataFilter();
        if(! empty( $post ) ){
            $this->setBrandFromPost($post);
        }
    }


    /*
     * Set Brand from Api Data
     */
    public function setBrandFromApi($data)
    {
        $baseUrlForCalendar = explode('packages', $data->my_package_reservations_link);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->taxLabel = $data->tax_label;
        $this->websiteLink = $data->website_link;
        $this->publicReservationsLinkFull = $data->public_reservations_link_full;
        $this->publicPackagesLinkFull = $data->public_packages_link_full;
        $this->publicReservationsFirstStepLink = $data->public_reservations_link_first_step;
        $this->publicPackagesFirstStepLink = $data->public_packages_link_first_step;
        $this->publicReservationPackagesFirstStepLink = $data->public_reservations_packages_link_first_step;
        $this->myReservationsLink = $data->my_reservations_link;
        $this->myPackagesReservationsLink = $data->my_package_reservations_link;
        $this->publicCalendarLink = $baseUrlForCalendar[0] . 'calendar?brand_id=' . $data->uuid;
    }

    /*
     * Create Brand Model Custom Post
     */
    public function create()
    {
        $this->postArgs = array_merge(
            $this->postArgs,
            array(
                'post_title'    =>  $this->name,
                'post_name'     =>  $this->name
            )
        );
        $post_id = wp_insert_post( $this->postArgs );
        $this->post_id = $post_id;
        hq_update_post_meta( $post_id, $this->metaId, $this->id );
        hq_update_post_meta( $post_id, $this->metaName, $this->name );
        hq_update_post_meta( $post_id, $this->metaTaxLabel, $this->taxLabel );
        hq_update_post_meta( $post_id, $this->metaWebsiteLink, $this->websiteLink );
        hq_update_post_meta( $post_id, $this->metaPublicReservationsLinkFull, $this->publicReservationsLinkFull );
        hq_update_post_meta( $post_id, $this->metaPublicPackagesLinkFull, $this->publicPackagesLinkFull );
        hq_update_post_meta( $post_id, $this->metaPublicReservationsFirstStepLink, $this->publicReservationsFirstStepLink );
        hq_update_post_meta( $post_id, $this->metaMyReservationsLink, $this->myReservationsLink );
        hq_update_post_meta( $post_id, $this->metaMyPackagesReservationsLink, $this->myPackagesReservationsLink );
        hq_update_post_meta( $post_id, $this->metaPublicCalendarLink, $this->publicCalendarLink );
    }

    /*
     * Find
     */
    public function find($brandId)
    {
        $args = array_merge(
            $this->postArgs,
            array(
                'meta_query'  =>  array(
                    array(
                        'key'     => $this->metaId,
                        'value'   => $brandId,
                        'compare' => '=',
                    )
                )
            )
        );
        $query = new \WP_Query( $args );
        $this->setBrandFromPost($query->posts[0]->ID);
    }
    public function setBrandFromPost($brandPost)
    {
        $this->id = get_post_meta($brandPost->ID, $this->metaId, true);
        $this->name = get_post_meta( $brandPost->ID, $this->metaName, true);
        $this->taxLabel = get_post_meta($brandPost->ID, $this->metaTaxLabel, true);
        $this->websiteLink = get_post_meta($brandPost->ID, $this->metaWebsiteLink, true);
        $this->publicReservationsLinkFull = get_post_meta( $brandPost->ID, $this->metaPublicReservationsLinkFull, true );
        $this->publicPackagesLinkFull = get_post_meta( $brandPost->ID, $this->metaPublicPackagesLinkFull, true );
        $this->publicReservationsFirstStepLink = get_post_meta( $brandPost->ID, $this->metaPublicReservationsFirstStepLink, true );
        $this->publicPackagesFirstStepLink = get_post_meta($brandPost->ID, $this->metaPublicPackagesFirstStepLink, true );
        $this->publicReservationPackagesFirstStepLink = get_post_meta( $brandPost->ID, $this->metaPublicReservationPackagesFirstStepLink, true );
        $this->myReservationsLink = get_post_meta( $brandPost->ID, $this->metaMyReservationsLink, true );
        $this->myPackagesReservationsLink = get_post_meta(  $brandPost->ID, $this->metaMyPackagesReservationsLink, true );
        $this->publicCalendarLink = get_post_meta( $brandPost->ID, $this->metaPublicCalendarLink, true );
    }

    public function setBrandFromPostId($id)
    {
        $this->id = get_post_meta($id, $this->metaId, true);
        $this->name = get_post_meta( $id, $this->metaName, true);
        $this->taxLabel = get_post_meta($id, $this->metaTaxLabel, true);
        $this->websiteLink = get_post_meta($id, $this->metaWebsiteLink, true);
        $this->publicReservationsLinkFull = get_post_meta( $id, $this->metaPublicReservationsLinkFull, true );
        $this->publicPackagesLinkFull = get_post_meta( $id, $this->metaPublicPackagesLinkFull, true );
        $this->publicReservationsFirstStepLink = get_post_meta( $id, $this->metaPublicReservationsFirstStepLink, true );
        $this->publicPackagesFirstStepLink = get_post_meta($id, $this->metaPublicPackagesFirstStepLink, true );
        $this->publicReservationPackagesFirstStepLink = get_post_meta( $id, $this->metaPublicReservationPackagesFirstStepLink, true );
        $this->myReservationsLink = get_post_meta( $id, $this->metaMyReservationsLink, true );
        $this->myPackagesReservationsLink = get_post_meta(  $id, $this->metaMyPackagesReservationsLink, true );
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
    public function findBySystemId($hqBrandId)
    {
        $args = array_merge(
            $this->postArgs,
            array(
                'meta_query'  =>  array(
                    array(
                        'key'     => $this->metaId,
                        'value'   => $hqBrandId,
                        'compare' => '=',
                    )
                )
            )
        );
        $query = new \WP_Query( $args );
        return $this->setBrandFromPost($query->posts[0]);
    }
}