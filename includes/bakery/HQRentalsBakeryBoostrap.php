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
    }
    public function requireDependencies()
    {
        foreach ($this->resolveFiles() as $file) {
            if (file_exists($file)) {
                require_once($file);
            }
        }
    }
    public function resolveFiles(){
        return array_merge(
            $this->dependencies,
            array(
                plugin_dir_path( __FILE__ ) . 'shortcodes/HQRentalsBakeryVehicleGridShortcode.php'
            )
        );
    }

}