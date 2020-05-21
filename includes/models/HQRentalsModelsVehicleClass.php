<?php

namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsLocaleHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesFeatures;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;




class HQRentalsModelsVehicleClass extends HQRentalsBaseModel
{
    public static $custom_fields = [];
    /*
     * HQ Rental Custom Post Type Configuration
     */
    public $vehicleClassesCustomPostName = 'hqwp_veh_classes';
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
    protected $metaPublicImageLink = 'hq_wordpress_vehicle_class_public_image_link_meta';
    protected $metaLabelForWebsite = 'hq_wordpress_vehicle_class_label_for_website_meta';
    protected $metashortDescriptionForWebiste = 'hq_wordpress_vehicle_class_short_description_meta';
    protected $metaDescriptionForWebiste = 'hq_wordpress_vehicle_class_description_for_webiste_meta';
    protected $metaCustomField = 'hq_wordpress_vehicle_class_custom_field_';
    /*
     * Object Data to Display
     */
    public $id = '';
    public $postId = '';
    public $brandId = '';
    public $name = '';
    public $order = '';
    public $availableOnWebsite = '';
    public $publicImageLink = '';
    public $labels = [];
    public $shortDescriptions = [];
    public $descriptions = [];
    public $images = [];
    public $features = [];
    public $rate = [];
    public $customField = [];
    public $permalink = '';
    public $priceIntervals = [];

    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->locale = new HQRentalsLocaleHelper();
        $this->queryFeatures = new HQRentalsQueriesFeatures();
        $this->pluginSettings = new HQRentalsSettings();
        $this->postArgs = [
            'post_type' => $this->vehicleClassesCustomPostName,
            'post_status' => 'publish',
            'posts_per_page' => -1,
        ];
        $this->labelsPost = [
            'name' => _x('Vehicle Classes', 'post type general name', 'your-plugin-textdomain'),
            'singular_name' => _x('Vehicle Class', 'post type singular name', 'your-plugin-textdomain'),
            'menu_name' => _x('Vehicle Classes', 'admin menu', 'your-plugin-textdomain'),
            'name_admin_bar' => _x('Vehicle Class', 'add new on admin bar', 'your-plugin-textdomain'),
            'add_new' => _x('Add New', 'brand', 'your-plugin-textdomain'),
            'add_new_item' => __('Add New Vehicle Class', 'your-plugin-textdomain'),
            'new_item' => __('New Vehicle Class', 'your-plugin-textdomain'),
            'edit_item' => __('Edit Vehicle Class', 'your-plugin-textdomain'),
            'view_item' => __('View Vehicle Class', 'your-plugin-textdomain'),
            'all_items' => __('All Vehicle Classes', 'your-plugin-textdomain'),
            'search_items' => __('Search Vehicle Classes', 'your-plugin-textdomain'),
            'parent_item_colon' => __('Parent Vehicle Classes', 'your-plugin-textdomain'),
            'not_found' => __('No vehicles classes found.', 'your-plugin-textdomain'),
            'not_found_in_trash' => __('No vehicles classes found in Trash.', 'your-plugin-textdomain'),
        ];
        $this->customPostArgs = [
            'labels'                    => $this->labelsPost,
            'public'                    => true,
            'show_in_admin_bar'         => true,
            'publicly_queryable'        => true,
            'show_ui'                   => true,
            'show_in_menu'              => true,
            'show_in_nav_menus'         => true,
            'query_var'                 => true,
            'rewrite'                   => ['slug' => $this->vehicleClassesCustomPostSlug],
            'has_archive'               => true,
            'hierarchical'              => false,
            'exclude_from_search'       => false,
            'menu_icon'                 => 'dashicons-thumbs-up',
            'menu_position'             => 8,
            'supports'                  => ['title', 'editor', 'thumbnail', 'excerpt'],
            'capabilities'              => [
                'create_posts' => 'do_not_allow',
            ],
        ];
        if (!empty($post)) {
            $this->setFromPost($post);
        }
    }

    /*
     * set Vehicle Class From Api
     */
    public function setVehicleClassFromApi($data, $customFields = null)
    {

        $this->id = $data->id;
        $this->brandId = $data->brand->id;
        $this->name = $data->name;
        $this->order = $data->order;
        $this->publicImageLink = $data->public_image_link;
        if(!empty($data->label_for_website)){
            foreach ($data->label_for_website as $key => $label) {
                $this->labels[$key] = $label;
            }
        }

        if(!empty($data->short_description_for_website)){
            foreach ($data->short_description_for_website as $key => $shortDescription) {
                $this->shortDescriptions[$key] = $shortDescription;
            }
        }
        if(!empty($data->description_for_website)){
            foreach ($data->description_for_website as $key => $description) {
                $this->descriptions[$key] = $description;
            }
        }

        if(!empty($data->images)){
            foreach ($data->images as $image) {
                $newImage = new HQRentalsModelsVehicleClassImage();
                $newImage->setVehicleClassImageFromApi($this->id, $image);
                $this->images[] = $newImage;
            }
        }

        foreach ($data->features as $feature) {
            $newFeature = new HQRentalsModelsFeature();
            $newFeature->setFeatureFromApi($this->id, $feature);
            $this->features[] = $newFeature;
        }
        if (!empty($data->activeRates)) {
            foreach ($data->activeRates as $rate){
                $newRate = new HQRentalsModelsActiveRate();
                $newRate->setActiveRateFromApi($this->id, $rate);
                $this->rate[] = $newRate;
                if(is_array($rate->price_intervals)){
                    if(count($rate->price_intervals) > 0){
                        foreach ($rate->price_intervals as $price){
                            $newPrice = new HQRentalsModelsPriceInterval();
                            $newPrice->setIntervalRateFromApi($price, $this->id);
                            $this->priceIntervals[] = $newPrice;
                        }
                    }
                }
            }
        }
        if(!empty($customFields->data)){
            foreach ($customFields->data as $custom_field) {
                $this->{$this->metaCustomField . $custom_field->dbcolumn} = $data->{$custom_field->dbcolumn};
            }
        }
    }

    /*
     * Create Vehicle Class Custom Post
     */
    public function create()
    {

        $this->postArgs = array_merge(
            $this->postArgs,
            [
                'post_title' => $this->name,
                'post_name' => $this->name,
                'post_content' => $this->descriptions['en'] . $this->shortDescriptions['en'],
            ]
        );
        $post_id = wp_insert_post($this->postArgs);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaId, $this->id);
        hq_update_post_meta($post_id, $this->metaBrandId, $this->brandId);
        hq_update_post_meta($post_id, $this->metaName, $this->name);
        hq_update_post_meta($post_id, $this->metaOrder, $this->order);
        hq_update_post_meta($post_id, $this->metaAvailableOnWebsite, $this->availableOnWebsite);

        hq_update_post_meta($post_id, $this->metaPublicImageLink, $this->publicImageLink);
        foreach ($this->labels as $key => $value) {
            hq_update_post_meta($post_id, $this->metaLabelForWebsite . '_' . $key, $value);
        }
        foreach ($this->shortDescriptions as $key => $value) {
            hq_update_post_meta($post_id, $this->metashortDescriptionForWebiste . '_' . $key, $value);
        }
        foreach ($this->descriptions as $key => $value) {
            hq_update_post_meta($post_id, $this->metaDescriptionForWebiste . '_' . $key, $value);
        }
        foreach ($this->features as $feature) {
            $feature->create();
        }
        foreach ($this->images as $image) {
            $image->create();
        }
        foreach (static::$custom_fields as $custom_field) {
            hq_update_post_meta($post_id, $this->metaCustomField . $custom_field, $this->{$this->metaCustomField . $custom_field});
        }
        if (!empty($this->rate)) {
            foreach ($this->rate as $rate){
                if($rate instanceof HQRentalsModelsActiveRate){
                    $rate->create();
                }
            }
        }
        if(!empty($this->priceIntervals)){
            foreach ($this->priceIntervals as $price){
                if(!empty($price)){
                    $price->create();
                }
            }
        }
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

    public function getAllMetaTags()
    {
        return [
            'id' => $this->metaId,
            'brandId' => $this->metaBrandId,
            'name' => $this->metaName,
            'order' => $this->metaOrder,
            'availableOnWebsite' => $this->metaAvailableOnWebsite,
            'publicImageLink' => $this->metaPublicImageLink,
        ];
    }

    /**
     * @param $post
     */
    public function setFromPost($post)
    {
        $this->name = $post->post_name;
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
            $this->shortDescriptions[end($metakey)] = get_post_meta($post->ID, $value[0], true);
        }
        foreach ($descriptionsKeys as $key => $value) {
            $metakey = explode('_', $value[0]);
            $this->descriptions[end($metakey)] = get_post_meta($post->ID, $value[0], true);
        }
        $this->postId = $post->ID;
        $this->permalink = get_permalink($post->ID);
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

    public function rate()
    {
        return new HQRentalsModelsActiveRate($this->id);
    }
    public function rates()
    {
        $rateModel = new HQRentalsModelsActiveRate();
        return $rateModel->allRatesFromVehicleClass($this->id);
    }

    public function getPriceIntervals()
    {
        $prices = new HQRentalsModelsPriceInterval();
        $data= [];
        foreach ($prices->getIntervalPricesByVehicleId( $this->id ) as $pricePost){
            $data[] = new HQRentalsModelsPriceInterval($pricePost);
        }
        return $data;
    }

    public function images()
    {
        $images = new HQRentalsModelsVehicleClassImage();
        $imagesForReturn = [];
        foreach ($images->getImagesPostByVehicleClassID($this->id) as $post) {
            $imagesForReturn[] = new HQRentalsModelsVehicleClassImage($post);
        }

        return $imagesForReturn;
    }

    public function getImage()
    {
        $imageModel = new HQRentalsModelsVehicleClassImage();
        $imagePost = $imageModel->getImageFromPostByVehicleClassID($this->id);
        return new HQRentalsModelsVehicleClassImage($imagePost);
    }

    public function features()
    {
        $query = new HQRentalsQueriesFeatures();
        return $query->getVehicleClassFeatures($this->id);
    }

    public function getDescription($forced_locale = null)
    {
        if (!empty($forced_locale)) {
            return $this->descriptions[$forced_locale];
        } else {
            return $this->descriptions[$this->locale->language];
        }
    }

    public function getLabel($forcedLocale = null)
    {
        if (!empty($forcedLocale)) {
            return $this->labels[$forcedLocale];
        } else {
            if($this->locale->language === "zh"){
                return $this->labels["zh-Hans"];
            }
            return $this->labels[$this->locale->language];
        }
    }
    public function getLabels(){
        return $this->labels;
    }
    public function getDescriptions(){
        return $this->descriptions;
    }
    public function getCustomFields()
    {
        return $this->customField;
    }

    public function getShortDescription($forced_locale = null)
    {
        if (!empty($forced_locale)) {
            return $this->shortDescriptions[$forced_locale];
        } else {
            return $this->shortDescriptions[$this->locale->language];
        }
    }

    public function getCustomDataProperties()
    {
        $properties = get_object_vars($this);
        $customProperties = [];
        foreach ($properties as $key => $property) {
            if (strpos($key, $this->metaCustomField) >= 0) {
                $customProperties[] = $key;
            }
        }

        return $customProperties;
    }

    public function getCustomField($dbColumn)
    {
        return get_post_meta($this->postId, $this->metaCustomField . $dbColumn, true);
    }

    public function getCustomFieldMetaPrefix()
    {
        return $this->metaCustomField;
    }
    public function getVehicleClassIdMeta()
    {
        return $this->metaId;
    }

    public function getCheapestPriceInterval()
    {
        $price = new HQRentalsModelsPriceInterval();
        $cheapestPost = $price->getCheapestPriceInterval($this->id);
        $interval = new HQRentalsModelsPriceInterval($cheapestPost);
        return $interval;
    }

    public function getUsersPriceIntervalOption($cheapest = true)
    {
        $price = new HQRentalsModelsPriceInterval();
        if($cheapest){
            $post = $price->getCheapestPriceInterval($this->id);
        }else{
            $post = $price->getHighestPriceInterval($this->id);
        }
        $interval = new HQRentalsModelsPriceInterval($post);
        return $interval;
    }

    public function getOrderMetaKey()
    {
        return $this->metaOrder;
    }

    public function getBrandIdMetaKey()
    {
        return $this->metaBrandId;
    }
    public function getFeatureImage($size = '500')
    {
        return  str_replace('size=1000', 'size=' . $size, $this->publicImageLink);
    }
    public function getFeaturesPublicInterface()
    {
        $queryFeatures = new HQRentalsQueriesFeatures();
        return $queryFeatures->featuresPublicInterface($this->features());
    }
    public function getRatePublicInterface()
    {
        $rate = $this->rate();
        return $rate->ratePublicInterface();
    }
}

