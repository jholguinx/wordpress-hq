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

    /*
     * Constructor
     */
    public function __construct( $id = null )
    {
        $this->post_id = '';
        $this->systemId = $id;
        $this->postArgs = array(
            'post_type'     =>  $this->brandsCustomPostName,
            'post_status'   =>  'publish',
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
            'capability_type'           => 'post'
        );
        $this->filter = new HQRentalsDataFilter();
    }


    /*
     * Set Brand from Api Data
     */
    public function setBrandFromApi($data)
    {
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
        update_post_meta( $post_id, $this->metaId, $this->id );
        update_post_meta( $post_id, $this->metaName, $this->name );
        update_post_meta( $post_id, $this->metaTaxLabel, $this->taxLabel );
        update_post_meta( $post_id, $this->metaWebsiteLink, $this->websiteLink );
        update_post_meta( $post_id, $this->metaPublicReservationsLinkFull, $this->publicReservationsLinkFull );
        update_post_meta( $post_id, $this->metaPublicPackagesLinkFull, $this->publicPackagesLinkFull );
        update_post_meta( $post_id, $this->metaPublicReservationsFirstStepLink, $this->publicReservationsFirstStepLink );
        update_post_meta( $post_id, $this->metaMyReservationsLink, $this->myReservationsLink );
        update_post_meta( $post_id, $this->metaMyPackagesReservationsLink, $this->myPackagesReservationsLink );
    }
    /*
     * Update Brand Custom Post Information
     */
    public function update()
    {
        update_post_meta( $this->post_id, $this->metaId, $this->id );
        update_post_meta( $this->post_id, $this->metaName, $this->name );
        update_post_meta( $this->post_id, $this->metaTaxLabel, $this->taxLabel );
        update_post_meta( $this->post_id, $this->metaWebsiteLink, $this->websiteLink );
        update_post_meta( $this->post_id, $this->metaPublicReservationsLinkFull, $this->publicReservationsLinkFull );
        update_post_meta( $this->post_id, $this->metaPublicPackagesLinkFull, $this->publicPackagesLinkFull );
        update_post_meta( $this->post_id, $this->metaPublicReservationsFirstStepLink, $this->publicReservationsFirstStepLink );
        update_post_meta( $this->post_id, $this->metaMyReservationsLink, $this->myReservationsLink );
        update_post_meta( $this->post_id, $this->metaMyPackagesReservationsLink, $this->myPackagesReservationsLink );
    }
    /*
     * Delete Brand Custom Post
     */
    public function delete()
    {
        delete_post_meta( $this->post_id, $this->metaId );
        delete_post_meta( $this->post_id, $this->metaName );
        delete_post_meta( $this->post_id, $this->metaTaxLabel );
        delete_post_meta( $this->post_id, $this->metaWebsiteLink );
        delete_post_meta( $this->post_id, $this->metaPublicReservationsLinkFull );
        delete_post_meta( $this->post_id, $this->metaPublicPackagesLinkFull );
        delete_post_meta( $this->post_id, $this->metaPublicReservationsFirstStepLink );
        delete_post_meta( $this->post_id, $this->metaMyReservationsLink );
        delete_post_meta( $this->post_id, $this->metaMyPackagesReservationsLink );
        $post_id = wp_delete_post( $this->post_id , true );
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
        $this->setBrandFromPost($query->posts[0]);
    }
    public function setBrandFromPost($brandPost)
    {
        $this->id = get_post_meta($brandPost, $this->metaId, true);
        $this->name = get_post_meta( $brandPost, $this->metaName, true);
        $this->taxLabel = get_post_meta($brandPost, $this->metaTaxLabel, true);
        $this->websiteLink = get_post_meta($brandPost, $this->metaWebsiteLink, true);
        $this->publicReservationsLinkFull = get_post_meta( $brandPost, $this->metaPublicReservationsLinkFull, true );
        $this->publicPackagesLinkFull = get_post_meta( $brandPost, $this->metaPublicPackagesLinkFull, true );
        $this->publicReservationsFirstStepLink = get_post_meta( $brandPost, $this->metaPublicReservationsFirstStepLink, true );
        $this->publicPackagesFirstStepLink = get_post_meta($brandPost, $this->metaPublicPackagesFirstStepLink, true );
        $this->publicReservationPackagesFirstStepLink = get_post_meta( $brandPost, $this->metaPublicReservationPackagesFirstStepLink, true );
        $this->myReservationsLink = get_post_meta( $brandPost, $this->metaMyReservationsLink, true );
        $this->myPackagesReservationsLink = get_post_meta(  $brandPost, $this->metaMyPackagesReservationsLink, true );
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