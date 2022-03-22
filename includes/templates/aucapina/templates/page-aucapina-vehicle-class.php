<?php
/*
 * Template Name: Vehicle Class Page - Aucapina Theme
 */

use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;

$query = new HQRentalsDBQueriesVehicleClasses();

if (isset($_GET['id'])) {
    $vehicle = $query->getVehicleClassById($_GET['id']);
} else {
    wp_redirect('/', 302);
    return exit;
}

get_header();
global $post;

$with_booking = (templines_woocommerce_on() && !templines_mod('disable_booking'));
$with_sidebar = $with_booking || is_active_sidebar('catalog-page-sidebar');
$lang = apply_filters('wpml_current_language', null);

$meta = get_post_meta($post->ID);
if (!empty($meta['location_drop'][0])) {
    $meta['location_drop'] = explode(',', $meta['location_drop'][0]);
    foreach ($meta['location_drop'] as $i => $term_id) {
        $term = get_term($term_id);
        if (!$term) {
            unset($meta['location_drop'][$i]);
        }
    }
}
if (function_exists('templines_set_details_transient')) {
    $details = templines_set_details_transient('page');
} else {
    $details = [];
}
foreach ($details as $detail_slug => $detail) {
    $detail_slug_new = $detail_slug;
    if ($lang) {
        $detail_slug_new = preg_replace('~-' . $lang . '$~', '', $detail_slug_new);
    }
    $details[$detail_slug_new]['value'] = !empty($meta[$detail_slug]) ? $meta[$detail_slug] : [];
    $details[$detail_slug_new]['text'] = !empty($meta[$detail_slug][0]) ? $meta[$detail_slug][0] : '';
}
$index = 0;

if (function_exists('templines_set_features_transient')) {
    $features_top = templines_set_features_transient('top');
} else {
    $features_top = [];
}

if (function_exists('templines_set_features_transient')) {
    $features_list = templines_set_features_transient('list');
} else {
    $features_list = [];
}

$features = get_the_terms($post->ID, 'feature');
$feature_ids = [];
if ($features) {
    foreach ($features as $feature) {
        $feature_ids[] = $feature->term_id;
    }
}

$text = [];
$text_location_id = 0;
if ($locations = get_the_terms($post->ID, 'location')) {
    foreach ($locations as $location) {
        $text[] = $location->name;
        if (!$text_location_id) {
            $text_location_id = $location->term_id;
        }
    }
}
$text_location = implode(', ', $text);

if (empty($meta['location_drop'])) {
    $meta['location_drop'] = '';
}

$dates = function_exists('templines_get_filter_dates_range') ? templines_get_filter_dates_range() : [];

if (!empty($meta['price_on_request'][0])) {
    $price_on_request = templines_mod('price_on_request_label');
} else {
    $price = !empty($details['price']['text']) ? $details['price']['text'] : 0;
    if ($price && $dates) {
        $price = templines_get_price($post->ID, $dates['start'], $dates['end']);
        $diff = $dates['diff'];
    } else {
        $diff = 1;
    }
    $price_on_request = false;
}
?>
<?php HQRentalsAssetsHandler::getHQFontAwesome(); ?>
<header
    class="l-section c-page-header">
    <div class="c-page-header__image header-image" style="background-image:url(<?php echo get_the_post_thumbnail_url($post->ID); ?>)"></div>


    <div
        class="c-page-header__wrap <?php templines_class(!$title, 'c-page-header__wrap-small l-section__container'); ?>">
        <h1 class="l-section__container c-page-header__title"><?php echo $vehicle->getLabelForWebsite(); ?></h1>
        <h1 class="l-section__container c-page-header__title"><?php echo $vehicle->getLabelForWebsite(); ?></h1>
        <nav class="c-breadcrumbs">
            <ol class="c-breadcrumbs__list" itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <li class="c-breadcrumbs__item  c-breadcrumbs__item--first  " itemprop="itemListElement"
                    itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" title="Home" href="<?php echo home_url(); ?>"><span itemprop="name">Home</span></a>
                    <i class="ip-angle-double-right-solid c-breadcrumbs__separator"><!-- --></i>
                    <meta itemprop="position" content="1">
                </li>
                <li class="c-breadcrumbs__item  " itemprop="itemListElement" itemscope=""
                    itemtype="http://schema.org/ListItem">
                    <a itemprop="item" title="RV Rental Listings"
                       href="<?php echo get_home_url() . '/vehicle-class?id=' . $vehicle->getId(); ?>"><span itemprop="name"><?php echo $vehicle->getLabelForWebsite(); ?></span></a>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>
    </div>
</header>
<style>
    @media (min-width: 1170px) {
        .c-page-header {
            min-height: 550px !important;
        }
    }

    .c-vehicle-details__detail-list-wrap {
        display: block !important;
    }
    .header-image{
        background-size: 100%;
        filter: opacity(0.5);
    }
    .hq-calendar-wrapper{
        margin-top: 70px;
    }
</style>
<?php if (have_posts()): ?>
    <?php while (have_posts()) : the_post(); ?>
        <?php if ($price_on_request) { ?>
            <div class="c-header__callback-popup c-header__callback-popup--disabled js-callback-popup"
                 data-button=".js-request-price">
                <div class="c-header__callback-wrap">
                    <?php echo templines_shortcode(templines_mod('price_on_request_shortcode')); ?>
                    <button type="button" class="h-cb h-cb--svg c-header__callback-close js-callback-close"
                            id="templines-callback-close"><i class="ip-close"></i></button>
                </div>
            </div>
        <?php } ?>

        <div
            class="l-section l-section--container <?php if ($with_sidebar) { ?>l-section--with-sidebar<?php } ?> l-section--margin-120">
            <div
                class="l-section__content<?php if ($with_sidebar) { ?> l-section__content--with-sidebar<?php } ?>">
                <article id="vehicle-class-<?php echo $vehicle->getId(); ?>"
                         class="c-vehicle-details <?php templines_class(templines_mod('sticky_sidebar'), 'js-sticky-sidebar-nearby'); ?>">

                    <?php $section = []; ?>

                    <?php ob_start(); ?>
                    <?php $images = $vehicle->images(); ?>
                    <?php if (is_array($images) and count($images)) : ?>
                        <div class="c-vehicle-details__images-block">
                            <div>
                                <div class="slider-pro" id="vehicle-images-slider">
                                    <div class="sp-slides">
                                        <?php foreach ($images as $image): ?>
                                            <div class="sp-slide">
                                                <a data-fancybox="gallery" href="<?php echo $image->publicLink; ?>">
                                                    <img class="sp-image" src="https://cdnjs.cloudflare.com/ajax/libs/slider-pro/1.5.0/css/images/blank.gif" data-src="<?php echo $image->publicLink; ?>" />
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="sp-thumbnails">
                                        <?php foreach ($images as $image): ?>
                                            <div class="sp-thumbnail">
                                                <img class="sp-thumbnail-image" src="<?php echo $image->publicLink; ?>"/>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php ob_start(); ?>
                    <h1 class="c-vehicle-details__title"><?php echo $vehicle->getLabelForWebsite(); ?></h1>
                    <h2 class="c-vehicle-details__subtitle">
                        <?php if (array_key_exists('location', $details) && $locations) {
                            $detail = $details['location']; ?>
                            <span class="c-vehicle__location-icon-wrap"
                                  title="<?php echo esc_attr($detail['name']); ?>">
								<?php if (!empty($detail['image'])) { ?>
                                    <?php echo templines_wrap($detail['image']); ?>
                                <?php } elseif (!empty($detail['icon'])) { ?>
                                    <?php echo templines_wrap($detail['icon']); ?>
                                <?php } ?>
							</span>
                            <?php echo esc_html($text_location);
                            $with_location = true;
                        } ?>
                        <?php if (array_key_exists('subheader', $details) && !empty($details['subheader']['text'])) {
                            echo (!empty($with_location) ? ' - ' : '') . esc_html($details['subheader']['text']);
                        } ?>
                    </h2>
                    <hr class="left">
                    <?php $section['header'] = trim(ob_get_clean()); ?>
                    <?php ob_start(); ?>
                    <h3 class="c-vehicle-details__subheader"><?php esc_html_e('Description', 'aucapina') ?></h3>
                    <div class="entry-content entry-content--sidebar">
                        <?php echo $vehicle->getShortDescriptionForWebsite(); ?>
                    </div>
                    <?php $section['description'] = trim(ob_get_clean()); ?>

                    <?php ob_start(); ?>
                    <?php if ($details) { ?>
                        <h3 class="c-vehicle-details__subheader"><?php esc_html_e('Details', 'aucapina') ?></h3>
                        <div class="c-vehicle-details__detail-list-wrap">

                            <?php echo $vehicle->getShortDescriptionForWebsite(); ?>
                        </div>
                    <?php } ?>
                    <div
                        class="hq-calendar-wrapper"
                    >
                        <?php //echo do_shortcode('[hq_rentals_vehicle_calendar id='. $vehicle->id .']'); ?>
                        <?php echo do_shortcode('[hq_rentals_vehicle_calendar_snippet id="1" forced_locale="es" vehicle_class_id='. $vehicle->getId() .']'); ?>
                    </div>

                </article>
            </div>
            <div class="l-section__sidebar<?php if ($with_sidebar) { ?> l-section__sidebar--right<?php } ?>">
                <div class="c-vehicle-details__sidebar <?php templines_class(templines_mod('sticky_sidebar'), 'js-sticky-sidebar'); ?>">
                    <div>
                        <form method="GET" action="<?php echo home_url() . '/reservations/'; ?>" >
                            <div class="c-vehicle-book__wrap">
                                <ul class="c-vehicle-book__dates-list">
                                    <li class="c-vehicle-book__dates-item c-vehicle-book__dates-item--input">
                                        <input type="hidden" class="js-book-date-start" name="pick_up_date" value=""
                                               data-value="<?php echo esc_attr(!empty($_REQUEST['start']) ? $_REQUEST['start'] : (!empty($dates['start']) ? $dates['start']->format(templines_date_format()) : '')) ?>"/>
                                        <input type="hidden" class="js-book-date-end" name="return_date" value=""
                                               data-value="<?php echo esc_attr(!empty($_REQUEST['end']) ? $_REQUEST['end'] : (!empty($dates['end']) ? $dates['end']->format(templines_date_format()) : '')) ?>"/>
                                        <input type="text" class="c-vehicle-book__date js-book-date-range" value=""
                                               readonly/>
                                        <button class="h-cb c-vehicle-book__date-btn js-book-date-btn"
                                                type="button">
                                            <i class="ip-z-cal"><!-- --></i></button>
                                    </li>
                                </ul>
                                <div
                                    style="display: flex; flex: 1; justify-content: center; align-items: center;"
                                >
                                    <input type="hidden" name="pick_up_location" value="2" />
                                    <input type="hidden" name="return_location" value="2" />
                                    <input type="hidden" name="pick_up_time" value="10:00" />
                                    <input type="hidden" name="return_time" value="10:00" />
                                    <input type="hidden" name="vehicle_class_id" value="<?php echo $vehicle->getId(); ?>">
                                    <input type="hidden" name="target_step" value="3" />
                                    <button style="display: flex; flex: 1; justify-content: center; align-items: center; background-color:#a6dddb; color: #fff; padding: 20px 35px 21px 35px; font-family: Open Sans;"
                                            type="submit" class="h-cb c-vehicle-book__date-btn js-book-date-btn">Book Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-section">
            <div data-elementor-type="wp-post" class="elementor elementor-307">
                <div class="elementor-section-wrap">
                    <section class="elementor-section elementor-top-section elementor-element elementor-element-274df8f elementor-section-full_width elementor-section-height-default elementor-section-height-default" data-id="274df8f" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                        <?php do_shortcode('[hq_vehicle_grid]'); ?>
                    </section>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>f