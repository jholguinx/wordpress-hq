<?php
namespace HQRentalsPlugin\HQRentalsTemplates;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsTemplatesMenus
{
    protected $menuTitle = 'HQ Rentals Menu';
    public function __construct()
    {
        $this->menu = wp_get_nav_menu_object( $this->menuTitle );
        if(! $this->menuExists ){
            $this->menu_id = wp_create_nav_menu($this->menuTitle);
            $this->menu = wp_get_nav_menu_object( $this->menuTitle );
        }
        $this->brands = new HQRentalsModelsBrand();
    }
    public function updateMenuItems()
    {
        foreach ($this->brands->all() as $post){
            wp_update_nav_menu_item(
                $this->menu->term_id,
                0,
                array(
                    'menu-item-title'           => $post->post_title,
                    'menu-item-object-id'       => $post->ID,
                    'menu-item-object'          => 'post',
                    'menu-item-status'          => 'publish',
                    'menu-item-type'            => $this->brands->postArgs['post_type']
                )
            );
        }
    }
}