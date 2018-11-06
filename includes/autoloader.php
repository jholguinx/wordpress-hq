<?php
/**
 * Dynamically loads the class attempting to be instantiated elsewhere in the
 * plugin.
 *
 * @package Tutsplus_Namespace_Demo\Inc
 */

spl_autoload_register( 'tutsplus_namespace_demo_autoload' );

/**
 * Dynamically loads the class attempting to be instantiated elsewhere in the
 * plugin by looking at the $class_name parameter being passed as an argument.
 *
 * The argument should be in the form: TutsPlus_Namespace_Demo\Namespace. The
 * function will then break the fully-qualified class name into its pieces and
 * will then build a file to the path based on the namespace.
 *
 * The namespaces in this plugin map to the paths in the directory structure.
 *
 * @param string $class_name The fully-qualified name of the class to load.
 */
function hq_wordpress_autoloader( $class_name ) {

    // If the specified $class_name does not include our namespace, duck out.
    if ( false === strpos( $class_name, 'HQRentalsPlugin' ) ) {
        return;
    }
    // Split the class name into an array to read the namespace and class.
    $file_parts = explode( '\\', $class_name );

}

/*
 *  Folder Organizer
 */
function hq_wordpress_folder_selector($folder)
{
    switch($folder){
        case (''):
    }
}
