<?php
namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsVehicleClassImage
{
    /*
     * Custom Post Configuration
     */
    public $vehicleClassImageCustomPostName = 'hqwp_vehicle_image';
    public $vehicleClassImageCustomPostSlug = 'vehicle-class-image';

    /*
     * HQ Rentals Image Data
     * Custom Post Metas
     */

    protected $metaId = 'hq_wordpress_vehicle_image_id_meta';
    protected $metaVehicleClassId = 'hq_wordpress_vehicle_image_vehicle_class_id_meta';
    protected $metaFilename = 'hq_wordpress_vehicle_image_filename_meta';
    protected $metaExtension = 'hq_wordpress_vehicle_image_extension_meta';
    protected $metaMime = 'hq_wordpress_vehicle_image_mime_meta';
    protected $metaSize = 'hq_wordpress_vehicle_image_size_meta';
    protected $metaLabel = 'hq_wordpress_vehicle_image_label_meta';
    protected $metaPublicLink = 'hq_wordpress_vehicle_image_public_link_meta';

    /*
     * Object Data to Display
     */
    protected $id = '';
    protected $vehicleClassId = '';
    protected $filename = '';
    protected $extension = '';
    protected $mime = '';
    protected $size = '';
    protected $label = '';
    protected $publicLink = '';

    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->vehicleClassImageCustomPostName,
            'post_status'   =>  'publish'
        );
    }

    public function setVehicleClassImageFromApi($vehicleId, $data)
    {
        $this->id = $data->id;
        $this->vehicleClassId = $vehicleId;
        $this->filename = $data->filename;
        $this->extension = $data->extension;
        $this->mime = $data->mime;
        $this->size = $data->size;
        $this->label = $data-> label;
        $this->publicLink = $data->public_link;
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
        update_post_meta( $post_id, $this->metaVehicleClassId, $this->vehicleClassId );
        update_post_meta( $post_id, $this->metaFilename, $this->filename );
        update_post_meta( $post_id, $this->metaExtension, $this->extension );
        update_post_meta( $post_id, $this->metaMime, $this->mime );
        update_post_meta( $post_id, $this->metaSize, $this->size );
        update_post_meta( $post_id, $this->metaLabel, $this->label );
        update_post_meta( $post_id, $this->metaPublicLink, $this->publicLink );
    }

    public function update()
    {
        update_post_meta( $this->post_id, $this->metaId, $this->id );
        update_post_meta( $this->post_id, $this->metaVehicleClassId, $this->vehicleClassId );
        update_post_meta( $this->post_id, $this->metaFilename, $this->filename );
        update_post_meta( $this->post_id, $this->metaExtension, $this->extension );
        update_post_meta( $this->post_id, $this->metaMime, $this->mime );
        update_post_meta( $this->post_id, $this->metaSize, $this->size );
        update_post_meta( $this->post_id, $this->metaLabel, $this->label );
        update_post_meta( $this->post_id, $this->metaPublicLink, $this->publicLink );
    }

    public function delete()
    {
        delete_post_meta( $this->post_id, $this->metaId );
        delete_post_meta( $this->post_id, $this->metaVehicleClassId );
        delete_post_meta( $this->post_id, $this->metaFilename );
        delete_post_meta( $this->post_id, $this->metaExtension );
        delete_post_meta( $this->post_id, $this->metaMime );
        delete_post_meta( $this->post_id, $this->metaSize );
        delete_post_meta( $this->post_id, $this->metaLabel );
        delete_post_meta( $this->post_id, $this->metaPublicLink );
        $post_id = wp_delete_post( $this->post_id , true );
    }
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