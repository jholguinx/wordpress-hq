<?php
get_header();
$url = 'https://codex.wordpress.org/Plugin_API/Filter_Reference/template_include';
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
