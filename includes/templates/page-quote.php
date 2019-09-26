<?php
get_header();
$get_data = $_GET;
$quote = $get_data['quote_id'];
$forced_locale = $get_data['forced_locale'];
$quote_brand_uuid = $get_data['quote_brand_uuid'];
?>
    <div class="hq-container">
        <div class="hq-iframe-wrapper">
            <?php echo do_shortcode('[hq_rentals_form_link url=' . $url . ']')?>
        </div>
    </div>
    <style>
        .hq-container{
            flex:1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hq-iframe-wrapper{
            flex:1;
        }
    </style>
<?php
get_footer();
