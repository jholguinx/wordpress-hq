<?php

namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsVehicleClassCustomFields
{
    /*
     *
     */
    public $customFieldsPostName = 'hqwp_veh_cfields';
    public $customFieldsPostSlug = 'vehicle-classes-fields';

    /*
     *
     */
    protected $idMeta = 'hq_wordpress_custom_field_meta_id';
    protected $vehicleClassIdMeta = 'hq_wordpress_custom_field_vehicle_class_id';
    protected $labelMeta = 'hq_wordpress_custom_field_label_meta';
    protected $typeMeta = 'hq_wordpress_custom_field_type_meta';
    protected $dbcolumnMeta = 'hq_wordpress_custom_field_db_column_meta';

    public $id = '';
    public $vehicleClassId = '';
    public $label = '';
    public $type = '';
    public $dbcolumn = '';

    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->customFieldsPostName,
            'post_status'   =>  'publish'
        );
    }
    public function setCustomFieldFromApi( $data, $vehicleClassId )
    {
        $this->id = $data->id;
        $this->vehicleClassId = $vehicleClassId;
        $this->label = $data->label;
        $this->type = $data->type;
        $this->dbcolumn = $data->dbcolumn;
    }
    public function create()
    {
        $queryArgs = array(
            $this->postArgs,
            array(
                'post_type' =>  $this->label,
                'post_name' =>  $this->label
            )
        );
        $post_id = wp_insert_post( $queryArgs );
        update_post_meta( $post_id, $this->idMeta, $this->id );
        update_post_meta( $post_id, $this->vehicleClassIdMeta, $this->vehicleClassId );
        update_post_meta( $post_id, $this->labelMeta, $this->label );
        update_post_meta( $post_id, $this->typeMeta, $this->type );
        update_post_meta( $post_id, $this->dbcolumnMeta, $this->dbcolumn );

    }
}