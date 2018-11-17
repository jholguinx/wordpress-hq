<?php
namespace HQRentalsPlugin\HQRentalsModels;
use HQRentalsPlugin\HQRentalsModels\HQRentalsVehicleClassImage;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsFeature;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsActiveRate;


class HQRentalsModelsVehicleClass
{
    /*
     * HQ Rental Custom Post Type Configuration
     */
    public $vehicleClassesCustomPostName  = 'hqwp_veh_classes';
    public $vehicleClassesCustomPostSlug = 'vehicle-classes';

    /*
     * HQ Rentals Vehicle Classes Data
     * Custom Post Metas
     */

    protected $metaId = 'hq_wordpress_vehicle_class_id_meta';
    protected $metaBrandId = 'hq_wordpress_vehicle_class_brand_id_meta';
    protected $metaName = 'hq_wordpress_vehicle_class_name_meta';
    protected $metaOrder = 'hq_wordpress_vehicle_class_order_meta';
    protected $metaAvailableOnWebsite = 'hq_wordpress_vehicle_class_available_on_website_meta';
    protected $metaRecommended = 'hq_wordpress_vehicle_class_recommended_meta';
    protected $metaActive = 'hq_wordpress_vehicle_class_active_meta';
    protected $metaPublicImageLink = 'hq_wordpress_vehicle_class_public_image_link_meta';
    protected $metaLabelForWebsite = 'hq_wordpress_vehicle_class_label_for_website_meta';
    protected $metashortDescriptionForWebiste = 'hq_wordpress_vehicle_class_short_description_meta';
    protected $metaDescriptionForWebiste = 'hq_wordpress_vehicle_class_description_for_webiste_meta';


    /*
     * Object Data to Display
     */
    protected $id = '';
    protected $brandId = '';
    protected $name = '';
    protected $order = '';
    protected $availableOnWebsite = '';
    protected $recommended = '';
    protected $active = '';
    protected $publicImageLink = '';
    protected $labels = [ ];
    protected $shortDescriptions = [ ];
    protected $descriptions = [ ];
    protected $images = [ ];
    protected $features = [ ];
    protected $rate = '';

    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->vehicleClassesCustomPostName,
            'post_status'   =>  'publish'
        );
    }

    /*
     * set Vehicle Class From Api
     */
    public function setVehicleClassFromApi($data)
    {
        $this->id = $data->id;
        $this->brandId = $data->brand_id;
        $this->name = $data->name;
        $this->order = $data->order;
        $this->availableOnWebsite = $data->available_on_website;
        $this->recommended = $data->recommended;
        $this->active = $data->active;
        $this->publicImageLink = $data->public_image_link;
        foreach ($data->label_for_website as $key => $label){
            $this->labels[$key] = $label;
        }
        foreach ($data->short_description_for_website as $key => $shortDescription){
            $this->shortDescriptions[$key] = $shortDescription;
        }
        foreach ($data->description_for_website as $key => $description){
            $this->descriptions[$key] = $description;
        }
        foreach ($data->images as $image){
            $newImage = new HQRentalsVehicleClassImage();
            $newImage->setVehicleClassImageFromApi($this->id, $image);
            $this->images[] = $newImage;
        }
        foreach ($data->features as $feature){
            $newFeature = new HQRentalsModelsFeature();
            $newFeature->setFeatureFromApi( $this->id, $feature );
            $this->features[] = $newFeature;
        }
        $newRate = new HQRentalsModelsActiveRate();
        $newRate->setActiveRateFromApi($data->active_rates[0]);
        $this->rate = $newRate;
    }

    /*
     * Create Vehicle Class Custom Post
     */
    public function create()
    {
        $this->postArgs = array_merge(
            $this->postArgs,
            array(
                'post_title'     =>  $this->name,
                'post_name'     =>  $this->name
            )
        );
        $post_id = wp_insert_post( $this->postArgs );
        $this->post_id = $post_id;
        update_post_meta( $post_id, $this->metaId, $this->id );
        update_post_meta( $post_id, $this->metaBrandId, $this->brandId );
        update_post_meta( $post_id, $this->metaName, $this->name );
        update_post_meta( $post_id, $this->metaOrder, $this->order );
        update_post_meta( $post_id, $this->metaAvailableOnWebsite, $this->availableOnWebsite );
        update_post_meta( $post_id, $this->metaRecommended, $this->recommended );
        update_post_meta( $post_id, $this->metaActive, $this->active );
        update_post_meta( $post_id, $this->metaPublicImageLink, $this->publicImageLink );
        foreach ( $this->labels as $key => $value ){
            update_post_meta( $post_id, $this->metaLabelForWebsite . '_' . $key, $value);
        }
        foreach ( $this->shortDescriptions as $key => $value ){
            update_post_meta( $post_id, $this->metashortDescriptionForWebiste . '_' . $key, $value );
        }
        foreach ( $this->descriptions as $key => $value ){
            update_post_meta( $post_id, $this->metaDescriptionForWebiste . '_' . $key, $value );
        }
        foreach ( $this->images as $image ){
            $image->create();
        }
        foreach ( $this->features as $feature ){
            $feature->create();
        }
        $this->rate->create();
    }
    
    public function update()
    {
        update_post_meta( $this->post_id, $this->metaId, $this->id );
        update_post_meta( $this->post_id, $this->metaBrandId, $this->brandId );
        update_post_meta( $this->post_id, $this->metaName, $this->name );
        update_post_meta( $this->post_id, $this->metaOrder, $this->order );
        update_post_meta( $this->post_id, $this->metaAvailableOnWebsite, $this->availableOnWebsite );
        update_post_meta( $this->post_id, $this->metaRecommended, $this->recommended );
        update_post_meta( $this->post_id, $this->metaActive, $this->active );
        update_post_meta( $this->post_id, $this->metaPublicImageLink, $this->publicImageLink );
    }

    public function delete()
    {
        delete_post_meta( $this->post_id, $this->metaId );
        delete_post_meta( $this->post_id, $this->metaBrandId );
        delete_post_meta( $this->post_id, $this->metaName );
        delete_post_meta( $this->post_id, $this->metaOrder );
        delete_post_meta( $this->post_id, $this->metaAvailableOnWebsite );
        delete_post_meta( $this->post_id, $this->metaRecommended );
        delete_post_meta( $this->post_id, $this->metaActive );
        delete_post_meta( $this->post_id, $this->metaPublicImageLink );
        $post_id = wp_delete_post( $this->post_id, true );
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
    }
    public function set($data)
    {
        if($this->filter->isPost($data)){

        }else{}
        //$metas =
    }
}