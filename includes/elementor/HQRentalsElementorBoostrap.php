<?php
namespace HQRentalsPlugin\HQRentalsElementor;
class HQRentalsElementorBoostrap{
    protected $dependencies = array(
        ABSPATH . 'wp-admin/includes/plugin.php',
    );
    public function __construct()
    {
        $this->requireDependencies();
    }
    public function boostrapElementor(){
        if(is_plugin_active('elementor/elementor.php')){
            HQRentalsElementorExtension::instance();
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
}