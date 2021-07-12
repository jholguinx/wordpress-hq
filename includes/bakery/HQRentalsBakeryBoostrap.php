<?php
namespace HQRentalsPlugin\HQRentalsBakery;
class HQRentalsBakeryBoostrap{
    protected $dependencies = array(
        ABSPATH . 'wp-admin/includes/plugin.php',
    );
    public function __construct()
    {
        $this->requireDependencies();
        $this->theme = wp_get_theme();
    }
    public function boostrapBakery(){
        if(is_plugin_active('js_composer/js_composer.php') and class_exists('WPBakeryShortCode')){
            $this->resolveBakeryItems();
            $this->resolveFileForMotorsTheme();
            $this->resolveFileForRentitTheme();
        }
    }
    public function requireDependencies()
    {
        foreach ($this->dependencies as $file) {
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
    public function resolveBakeryItems()
    {
        $deps = array(
            plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryReservationFormShortcode.php',
            plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryReservationsShortcode.php',
            plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryVehicleGridShortcode.php',
        );
        foreach ($deps as $file){
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
    public function resolveFileForMotorsTheme()
    {
        if (
            $this->theme->stylesheet === 'motors' or
            $this->theme->stylesheet === 'motors-child' or
            $this->theme->stylesheet === 'motors_child') {
            $themeDeps = array(
                plugin_dir_path( __FILE__ ) . 'motors/HQRentalBakeryMotorsVehicleGridShortcode.php',
                plugin_dir_path( __FILE__ ) . 'motors/HQRentalBakeryMotorsReservationFormShortcode.php',
            );
            foreach ($themeDeps as $file){
                if (file_exists($file)) {
                    require_once($file);
                }
            }
        }
    }
    public function resolveFileForRentitTheme()
    {
        if (
            $this->theme->stylesheet === 'rentit' or
            $this->theme->stylesheet === 'rentit-child' or
            $this->theme->stylesheet === 'rentit_child'
        ) {
            $themeDeps = array(
                plugin_dir_path( __FILE__ ) . 'rentit/HQRentalBakeryRentitReservationFormShortcode.php',
                plugin_dir_path( __FILE__ ) . 'rentit/HQRentalBakeryRentitSliderShortcode.php',
            );
            foreach ($themeDeps as $file){
                if (file_exists($file)) {
                    require_once($file);
                }
            }
        }
    }
    public function resolveFiles(){
        return array_merge(
            $this->dependencies,
            array(
                plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryVehicleGridShortcode.php',
                plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryReservationsShortcode.php',
                plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryReservationFormShortcode.php',
            )
        );
    }

}