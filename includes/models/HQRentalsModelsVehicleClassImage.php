<?php
namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsVehicleClassImage extends HQRentalsBaseModel
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
    protected $metaPublicLink = 'hq_wordpress_vehicle_image_public_link_meta';
    protected $metaVehicleClassPostId = 'hq_wordpress_vehicle_image_vehicle_class_post_id_meta';

    /*
     * Object Data to Display
     */
    public $id = '';
    public $vehicleClassId = '';
    public $filename = '';
    public $extension = '';
    public $publicLink = '';
    public $vehicleClassPostId = '';


    public function __construct( $post = null )
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'         =>  $this->vehicleClassImageCustomPostName,
            'post_status'       =>  'publish',
            'posts_per_page'    =>  -1
        );
        if(!empty($post)){
            $this->setFromPost( $post );
        }
    }

    public function setVehicleClassImageFromApi($vehicleId, $data)
    {
        $this->id = $data->id;
        $this->vehicleClassId = $vehicleId;
        $this->filename = $data->filename;
        $this->extension = $data->extension;
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
        hq_update_post_meta( $post_id, $this->metaId, $this->id );
        hq_update_post_meta( $post_id, $this->metaVehicleClassId, $this->vehicleClassId );
        hq_update_post_meta( $post_id, $this->metaFilename, $this->filename );
        hq_update_post_meta( $post_id, $this->metaExtension, $this->extension );
        hq_update_post_meta( $post_id, $this->metaPublicLink, $this->publicLink );
    }

    public function find($caagImage)
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

        }else{

        }
        //$metas =
    }
    public function getImagesPostByVehicleClassID($vehicleClassId)
    {
        $args = array_merge(
            $this->postArgs,
            array(
                'meta_query'    =>  array(
                    array(
                        'key'       =>  $this->metaVehicleClassId,
                        'value'     =>  $vehicleClassId,
                        'compare'   =>  '='
                    )

                )
            )
        );
        $query = new \WP_Query($args);
        return $query->posts;
    }
    public function getImageFromPostByVehicleClassID($vehicleClassId)
    {
        $posts = $this->getImagesPostByVehicleClassID($vehicleClassId);
        return $posts[0];
    }

    /**
     * Match Model Properties with Post Meta for Saving
     * @return array
     */
    public function getAllMetaTag()
    {
        return array(
            'id'                    =>  $this->metaId,
            'vehicleClassId'        =>  $this->vehicleClassId,
            'filename'              =>  $this->metaFilename,
            'extension'             =>  $this->metaExtension,
            'publicLink'            =>  $this->metaPublicLink,
            'vehicleClassPostId'    =>  $this->metaVehicleClassPostId
        );
    }
    public function setFromPost( $post )
    {
        foreach ($this->getAllMetaTag() as $property => $metakey){
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
        }
    }
    public function getImageWithSize($size = 500)
    {
        return $this->publicLink . '?size=' . $size;
    }
    public function getImagePublicLink(){
        return $this->getImageWithSize(1000);
    }

}