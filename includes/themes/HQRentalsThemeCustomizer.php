<?php

namespace HQRentalsPlugin\HQRentalsThemes;

class HQRentalsThemeCustomizer
{
    public function __construct()
    {
        add_action( 'customize_register', array($this,'addCustomizationToTheme') );

    }
    public function addCustomizationToTheme( $wp_customize )
    {
        $wp_customize->add_panel( 'hq_rental_theme_menu', array(
            'title' => __( 'HQ Rental Software' ),
            'description' => 'Theme Customization Options', // Include html tags such as <p>.
            'priority' => 300, // Mixed with top-level-section hierarchy.
            )
        );
        $wp_customize->add_section( 'images_section' , array(
            'title' => 'Images',
            'panel' => 'hq_rental_theme_menu',
        ) );
        $wp_customize->add_setting('tenant_logo',array(
            'default'=>'',
        ));

        $wp_customize->add_control(
            new \WP_Customize_Media_Control(
                $wp_customize, // WP_Customize_Manager
                'tenant_logo', // Setting id
                array( // Args, including any custom ones.
                    'label' => __( 'Tenant Logo' ),
                    'section' => 'images_section',
                )
            )
        );
    }
}
