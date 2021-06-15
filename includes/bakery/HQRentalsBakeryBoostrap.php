<?php
namespace HQRentalsPlugin\HQRentalsBakery;
class HQRentalsBakeryBoostrap{
    protected $dependencies = array(
        ABSPATH . 'wp-content/plugins/js_composer/js_composer.php',
    );
    public function __construct()
    {
        $this->requireDependencies();
    }
    public function boostrapBakery(){
        if(is_plugin_active('js_composer/js_composer.php')){
            $this->requireDependencies();
        }
        $this->resolveFileForMotorsTheme();
    }
    public function requireDependencies()
    {
        foreach ($this->resolveFiles() as $file) {
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
    public function resolveFileForMotorsTheme()
    {
        $theme = wp_get_theme();
        if ($theme->stylesheet === 'motors' or $theme->stylesheet === 'motors-child') {
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