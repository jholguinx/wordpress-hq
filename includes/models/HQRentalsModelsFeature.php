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

    protected $id = '';
    protected $vehicleClassId = '';
    protected $label = '';
    protected $icon = '';
    protected $order = '';

    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->featureVehicleClassPostName,
            'post_status'   =>  'publish'
        );
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
                'post_title'    =>  $this->label,
                'post_name'     =>  $this->label
            )
        );
        $post_id = wp_insert_post( $this->postArgs );
        $this->post_id = $post_id;
        update_post_meta( $post_id, $this->metaId, $this->id );
    }

}