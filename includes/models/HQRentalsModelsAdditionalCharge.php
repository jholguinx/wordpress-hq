<?php
namespace HQRentalsPlugin\HQRentalsModels;

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
    protected $metaMandatory = 'hq_wordpress_additional_charge_mandatory_meta';
    protected $metaSelectionType = 'hq_wordpress_additional_charge_selection_type_meta';
    protected $metaHardcoded = 'hq_wordpress_additional_charge_hardcode_meta';
    protected $metaRecommended = 'hq_wordpress_additional_charge_recommended_meta';
    protected $metaDescription = 'hq_wordpress_additional_charge_description_meta';
    protected $metaIcon = 'hq_wordpress_additional_charge_icon_meta';
    protected $metaLabelForWebsite = 'hq_wordpress_additional_charge_label_for_website_meta';
    protected $metaShortDescription = 'hq_wordpress_additional_charge_short_description_meta';
    protected $metaSelectionRange = 'hq_wordpress_additional_charge_selection_range_meta';



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
}