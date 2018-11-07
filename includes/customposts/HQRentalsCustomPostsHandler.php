<?php

namespace HQRentalsPlugin\HQRentalsCustomPosts;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;


class HQRentalsCustomPostsHandler
{
    public function __construct()
    {
        $this->brands = new HQRentalsModelsBrand();
        add_action( 'init', array( $this, 'registerAllHQRentalsCustomPosts' ));
    }
    /*
     * Register all Custom Posts
     */
    public function registerAllHQRentalsCustomPosts()
    {
        $argsBrands = array(
            'public'                    =>  false,
            'publicly_queryable'        =>  true,
            'show_ui'                   =>  false,
            'show_in_menu'              =>  false,
            'show_in_nav_menus'         =>  false,
            'query_var'                 =>  false,
            'rewrite'                   =>  array( 'slug' => $this->brands->brandsCustomPostSlug ),
            'capability_type'           =>  'post',
            'has_archive'               =>  true,
            'hierarchical'              =>  false,
            'exclude_from_search'       =>  false,
            'publicly_queryable'        =>  true,
            'supports'                  =>  array('title'),
            'capabilities'              =>  array(
                    'create_posts'      => 'do_not_allow',
            )
        );
        register_post_type($this->brands->brandsCustomPostName, $argsBrands);
    }
}