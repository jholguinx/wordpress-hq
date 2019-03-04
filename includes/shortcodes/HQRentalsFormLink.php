<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;

class HQRentalsFormLink
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_form_link' , array ($this, 'packagesShortcode'));
    }
    public function packagesShortcode( $atts = [] )
    {
        $atts = shortcode_atts(
                array(
                    'url'               => '',
                    'forced_locale'     =>  'en'
                ), $atts
            );
        $langParams = '&forced_locale=' . $atts['forced_locale'];
        wp_enqueue_style('hq-wordpress-styles');
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script('hq-resize-script');
        if(!empty($_POST['hq-integration'])){
            $post_data = $_POST;
            ?>
            <form action="<?php echo $atts['url']; ?>" method="POST"
                  target="hq-rental-iframe" id="hq-form-init">
                <?php foreach ($post_data as $key => $value): ?>
                        <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value; ?>" />
                <?php endforeach; ?>
                <input type="submit" style="display: none;">
            </form>
            <?php
            $this->assets->getFirstStepShortcodeAssets();
        }
        return '<iframe id="hq-rental-iframe" src="' . $atts['url'] .  $langParams . '" scrolling="no"></iframe>';
    }
}