<?php
namespace HQRentalsPlugin\HQRentalsHelpers;
use WP_Http;
class HQRentalsThumbnailHelper
{
    function __construct()
    {

    }


    public function setPostThumbnail( $url, $post_id, $file_name, $file_extension)
    {
        $http = new WP_Http();
        $response = $http->request( $url );
        if( is_wp_error($response) or $response['response']['code'] != 200){
            return false;
        }
        $upload = wp_upload_bits( basename(str_replace(' ', '', $file_name . '.' . $file_extension)), null, $response['body'] );
        if( !empty( $upload['error'] ) ) {
            return false;
        }
        $file_path = $upload['file'];
        $file_name = basename( $file_path );
        $file_type = wp_check_filetype( $file_name, null );
        $attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
        $wp_upload_dir = wp_upload_dir();
        /*
         * Attachments
         */
        $post_info = array(
            'guid'				=> $wp_upload_dir['url'] . '/' . $file_name,
            'post_mime_type'	=> $file_type['type'],
            'post_title'		=> $attachment_title,
            'post_content'		=> '',
            'post_status'		=> 'inherit',
        );
        // Create the attachment
        $attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );
        // Include image.php
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
        // Assign metadata to attachment
        wp_update_attachment_metadata( $attach_id,  $attach_data );
        return set_post_thumbnail( $post_id, $attach_id );
    }

    /*
     * Set Gallery
     */
    public function setPostGallery( $url, $post_id, $file_name, $file_extension)
    {
        if( !class_exists( 'WP_Http' ) ){
            include_once( ABSPATH . WPINC . '/class-http.php' );
        }
        $http = new WP_Http();
        $response = $http->request( $url );
        if( is_wp_error($response) or $response['response']['code'] != 200){
            return false;
        }
        $upload = wp_upload_bits( basename(str_replace(' ', '', $file_name . '.' . $file_extension)), null, $response['body'] );
        if( !empty( $upload['error'] ) ) {
            return false;
        }
        $file_path = $upload['file'];
        $file_name = basename( $file_path );
        $file_type = wp_check_filetype( $file_name, null );
        $attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
        $wp_upload_dir = wp_upload_dir();
        /*
         * Attachments
         */
        $post_info = array(
            'guid'				=> $wp_upload_dir['url'] . '/' . $file_name,
            'post_mime_type'	=> $file_type['type'],
            'post_title'		=> $attachment_title,
            'post_content'		=> '',
            'post_status'		=> 'inherit',
        );
        // Create the attachment
        $attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );
        $woo_helper = new WC_Product_Factory();
        $product = $woo_helper->get_product( $post_id );
        $product->set_gallery_image_ids( array_merge( $product->get_gallery_image_ids(), array( $attach_id )) );
        $product->save();

        // Include image.php
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Define attachment metadata
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

        // Assign metadata to attachment
        wp_update_attachment_metadata( $attach_id,  $attach_data );
        return set_post_thumbnail( $post_id, $attach_id );
    }
}