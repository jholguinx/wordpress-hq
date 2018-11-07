<?php
namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsModels\HQRentalsBaseModel;

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
    protected $id = '';
    protected $name = '';
    protected $taxLabel = '';
    protected $websiteLink = '';
    protected $publicReservationsLinkFull = '';
    protected $publicPackagesLinkFull = '';
    protected $publicReservationsFirstStepLink = '';
    protected $publicPackagesFirstStepLink = '';
    protected $publicReservationPackagesFirstStepLink = '';
    protected $myReservationsLink = '';
    protected $myPackagesReservationsLink = '';

    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->brandsCustomPostName,
            'post_status'   =>  'publish',
        );
    }
    /*
     * Set Brand from Api
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
    public function create( )
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
    public function save(){

    }
    public function find($id){

    }
    public function first()
    {
        // TODO: Implement first() method.
    }
    public function all(){

    }
}