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
    protected $metaMandatoryBrands = 'hq_wordpress_additional_charge_mandatory_brands_meta';
    protected $metaSelectionType = 'hq_wordpress_additional_charge_selection_type_meta';
    protected $metaRecommended = 'hq_wordpress_additional_charge_recommended_meta';
    protected $metaDescription = 'hq_wordpress_additional_charge_description_meta';
    protected $metaIcon = 'hq_wordpress_additional_charge_icon_meta';
    protected $metaLabelForWebsite = 'hq_wordpress_additional_charge_label_for_website_meta';
    protected $metaShortDescription = 'hq_wordpress_additional_charge_short_description_meta';
    protected $metaSelectionRange = 'hq_wordpress_additional_charge_selection_range_meta';


    /*
     * Object Data to Display
     */

    public $id = '';
    public $name = '';
    public $chargeType = '';
    public $mandatoryBrands = [];
    public $selectionType = '';
    public $recommended = '';
    public $descriptions = [];
    public $icon = '';
    public $labels = [];
    public $shortDescriptions = [];
    public $selectionRange = '';


    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->postArgs = array(
            'post_type' => $this->additionalChargesCustomPostName,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );
        /*
         * Custom Post Parameters
         */
        if (!empty($post)) {
            $this->setFromPost($post);
        }

    }

    public function setAdditionalChargeFromApi($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->chargeType = $data->charge_type;
        if (!empty($data->mandatory)) {
            foreach ($data->mandatory as $brandId) {
                $this->mandatoryBrands[] = $brandId;
            }
        }
        $this->selectionType = $data->selection_type;
        $this->hardcoded = $data->hardcoded;
        $this->recommended = $data->recommended;
        if (!empty($data->description)) {
            foreach ($data->description as $key => $value) {
                $this->descriptions[$key] = $value;
            }
        }
        if (!empty($data->short_description_for_website)) {
            foreach ($data->short_description_for_website as $key => $value) {
                $this->shortDescriptions[$key] = $value;
            }
        }
        if (!empty($data->label_for_website)) {
            foreach ($data->label_for_website as $key => $value) {
                $this->labels[$key] = $value;
            }
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
                'post_title' => $this->name,
                'post_name' => $this->name
            )
        );
        $post_id = wp_insert_post($this->postArgs);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaId, $this->id);
        hq_update_post_meta($post_id, $this->metaName, $this->name);
        hq_update_post_meta($post_id, $this->metaChargeType, $this->chargeType);
        foreach ($this->mandatoryBrands as $value) {
            hq_update_post_meta($post_id, $this->metaMandatoryBrands, $value);
        }
        hq_update_post_meta($post_id, $this->metaSelectionType, $this->selectionType);
        hq_update_post_meta($post_id, $this->metaHardcoded ?? '', $this->hardcoded ?? '');
        foreach ($this->descriptions as $key => $value) {
            hq_update_post_meta($post_id, $this->metaDescription . '_' . $key, $value);
        }
        hq_update_post_meta($post_id, $this->metaIcon, $this->icon);
        foreach ($this->labels as $key => $value) {
            hq_update_post_meta($post_id, $this->metaLabelForWebsite . '_' . $key, $value);
        }
        foreach ($this->shortDescriptions as $key => $value) {
            hq_update_post_meta($post_id, $this->metaShortDescription . '_' . $key, $value);
        }
        hq_update_post_meta($post_id, $this->metaSelectionRange, $this->selectionRange);
    }

    /*
     * Find
     */
    public function find($caag_id)
    {
        $query = new \WP_Query($this->postArgs);
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
        if ($this->filter->isPost($data)) {

        } else {
        }
        //$metas =
    }

    public function getMetaKeysFromLabel()
    {
        global $wpdb;
        return $wpdb->get_results(
            "SELECT DISTINCT(meta_key)
                    FROM {$wpdb->prefix}postmeta 
                    WHERE meta_key 
                    LIKE '{$this->metaLabelForWebsite}%'
                    ",
            ARRAY_N
        );
    }

    public function getMetaKeysFromShortDescription()
    {
        global $wpdb;
        return $wpdb->get_results(
            "SELECT DISTINCT(meta_key)
                    FROM {$wpdb->prefix}postmeta 
                    WHERE meta_key 
                    LIKE '{$this->metashortDescriptionForWebiste}%'
                    ",
            ARRAY_N
        );
    }

    /*
     * Eliminar en el futuro
     *
     */
    public function getMetaKeysFromDescription()
    {
        global $wpdb;
        return $wpdb->get_results(
            "SELECT DISTINCT(meta_key)
                    FROM {$wpdb->prefix}postmeta 
                    WHERE meta_key 
                    LIKE '{$this->metaDescriptionForWebiste}%'
                    ",
            ARRAY_N
        );
    }

    public function getAllMetaTags()
    {
        return array(
            'id' => $this->metaId,
            'name' => $this->metaName,
            'chargeType' => $this->metaChargeType,
            'mandatoryBrands' => $this->metaMandatoryBrands,
            'selectionType' => $this->metaSelectionType,
            'hardcoded' => $this->metaHardcoded,
            'recommended' => $this->metaRecommended,
            'descriptions' => $this->metaDescription,
            'icon' => $this->metaIcon,
            'labels' => $this->metaLabelForWebsite,
            'shortDescriptions' => $this->metaShortDescription,
            'selectionRange' => $this->metaSelectionRange
        );
    }

    public function setFromPost($post)
    {
        $labelsMetaKeys = $this->getMetaKeysFromLabel();
        $shortDescriptionKeys = $this->getMetaKeysFromShortDescription();
        $descriptionsKeys = $this->getMetaKeysFromDescription();
        foreach ($this->getAllMetaTags() as $property => $metakey) {
            if (!in_array($property, ['labels', 'shortDescriptions', 'descriptions'])) {
                $this->{$property} = get_post_meta($post->ID, $metakey, true);
            }
        }
        /*
         * Languages
         */
        foreach ($labelsMetaKeys as $key => $value) {
            $metakey = explode('_', $value[0]);
            $this->labels[end($metakey)] = get_post_meta($post->ID, $value[0], true);
        }
        foreach ($shortDescriptionKeys as $key => $value) {
            $metakey = explode('_', $value[0]);
            $this->shortDescription[end($metakey)] = get_post_meta($post->ID, $value[0], true);
        }
        foreach ($descriptionsKeys as $key => $value) {
            $metakey = explode('_', $value[0]);
            $this->description[end($metakey)] = get_post_meta($post->ID, $value[0], true);
        }
    }

    public function getAllAdditionalChargesPosts()
    {
        $query = new \WP_Query($this->postArgs);
        return $query->posts;
    }
}