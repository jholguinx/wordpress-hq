<?php
namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDataFilter;

class HQRentalsModelsAdditionalCharge extends HQRentalsBaseModel
{
    /*
     * Custom Post Configuration
     */
    public $additionalChargesCustomPostName = 'hqwp_charges';
    public $additionalChargesCustomPostSlug = 'additional-charges';

    /*
     * HQ Rentals Additional Charge Data
     * Custom Post Meta
     */
    protected $metaId = 'hq_wordpress_additional_charge_id_meta';
    protected $metaName = 'hq_wordpress_additional_charge_name_meta';
    protected $metaChargeType = 'hq_wordpress_additional_charge_charge_type_meta';
    protected $metaMandatoryBrands = 'hq_wordpress_additional_charge_mandatory_brands_meta';
    protected $metaSelectionType = 'hq_wordpress_additional_charge_selection_type_meta';
    protected $metaHardcoded = 'hq_wordpress_additional_charge_hardcoded_meta';
    protected $metaRecommended = 'hq_wordpress_additional_charge_recommended_meta';
    protected $metaDescription = 'hq_wordpress_additional_charge_description_meta';
    protected $metaIcon = 'hq_wordpress_additional_charge_icon_meta';
    protected $metaLabelForWebsite = 'hq_wordpress_additional_charge_label_for_website_meta';
    protected $metaShortDescription = 'hq_wordpress_additional_charge_short_description_meta';
    protected $metaSelectionRange = 'hq_wordpress_additional_charge_selection_range_meta';


    /*
     * Object Data to Display
     */

    protected $id = '';
    protected $name = '';
    protected $chargeType = '';
    protected $mandatoryBrands = [  ];
    protected $selectionType = '';
    protected $hardcoded = '';
    protected $recommended = '';
    protected $description = [ ];
    protected $icon = '';
    protected $labelForWebsite = [ ];
    protected $shortDescription = [ ];
    protected $selectionRange = '';
    public function __construct()
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type'     =>  $this->additionalChargesCustomPostName,
            'post_status'   =>  'publish'
        );
        /*
         * Custom Post Parameters
         */
        $this->filter = new HQRentalsDataFilter();
    }
    public function setAdditionalChargeFromApi($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->chargeType = $data->charge_type;
        if(!empty($data->mandatory)){
            foreach($data->mandatory as $brandId){
                $this->mandatoryBrands[] = $brandId;
            }
        }
        $this->selectionType = $data->selection_type;
        $this->hardcoded = $data->hardcoded;
        $this->recommended = $data->recommended;
        foreach ( $data->description as $key => $value ){
            $this->description[$key] = $value;
        }
        foreach ( $data->short_description_for_website as $key => $value ){
            $this->shortDescription[$key] = $value;
        }
        foreach ( $data->label_for_website as $key => $value ){
            $this->labelForWebsite[$key] = $value;
        }
        $this->selectionRange = $data->selection_range;
    }

    /*
     * Create Additional Charges
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
        update_post_meta( $post_id, $this->metaChargeType, $this->chargeType );
        foreach ( $this->mandatoryBrands as $value ){
            update_post_meta( $post_id, $this->metaMandatoryBrands, $value );
        }
        update_post_meta( $post_id, $this->metaSelectionType, $this->selectionType );
        update_post_meta( $post_id, $this->metaHardcoded, $this->hardcoded );
        foreach ( $this->description as $key => $value ){
            update_post_meta( $post_id, $this->metaDescription . '_' . $key, $value );
        }
        update_post_meta( $post_id, $this->metaIcon, $this->icon );
        foreach( $this->metaLabelForWebsite as $key => $value ){
            update_post_meta( $post_id, $this->metaLabelForWebsite . '_' . $key, $value );
        }
        foreach( $this->shortDescription as $key => $value ){
            update_post_meta( $post_id, $this->metaShortDescription . '_' . $key, $value );
        }
        update_post_meta( $post_id, $this->metaSelectionRange, $this->selectionRange );
    }

    public function update()
    {
        //*//dda
    }

    public function delete()
    {

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
    public function getAllMetaTags()
    {
        return array(
            'id'    =>  $this->metaId,
            'name'  =>  $this->metaName,
            'chargeType'    =>  $this->metaChargeType,
            'mandatoryBrands'
        )
    }
}