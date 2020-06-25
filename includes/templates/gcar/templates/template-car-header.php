<script src="https://kit.fontawesome.com/d2b6c51265.js" crossorigin="anonymous"></script>
<div id="page_caption"
     class="hasbg"
     style="background-image:url(<?php echo $vehicle->publicImageLink; ?>);"
>

    <div class="single_car_header_button">
        <div class="standard_wrapper">
            <?php
            //Get car gallery
            $car_gallery = get_post_meta($current_page_id, 'car_gallery', true);

            //Get gallery images
            $all_photo_arr = get_post_meta($car_gallery, 'wpsimplegallery_gallery', true);

            if (!empty($car_gallery) && !empty($all_photo_arr)) {
                $image_url = '';
                if (isset($all_photo_arr[0]) && !empty($all_photo_arr[0])) {
                    $image_url = wp_get_attachment_image_src($all_photo_arr[0], 'original', true);
                }
                ?>
                <a href="<?php echo esc_url($image_url[0]); ?>" id="single_car_gallery_open"
                   class="button fancy-gallery"><span
                            class="ti-camera"></span><?php esc_html_e('View Photos', 'grandcarrental'); ?></a>
                <div style="display:none;">
                    <?php
                    if (!empty($all_photo_arr)) {
                        foreach ($all_photo_arr as $key => $photo_id) {
                            if ($key > 0) {
                                $image_url = '';

                                if (!empty($photo_id)) {
                                    $image_url = wp_get_attachment_image_src($photo_id, 'original', true);
                                }

                                //Get image meta data
                                $image_caption = get_post_field('post_excerpt', $photo_id);
                                ?>
                                <a id="single_car_gallery_image<?php echo esc_attr($key); ?>"
                                   href="<?php echo esc_url($image_url[0]); ?>"
                                   title="<?php echo esc_attr($image_caption); ?>" class="fancy-gallery"></a>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <?php
            }
            ?>

            <?php
            //Get tour video review
            $car_video_review = get_post_meta($current_page_id, 'car_video_review', true);

            if (!empty($car_video_review)) {
                ?>
                <a href="#video_review<?php echo esc_attr($current_page_id); ?>" id="single_car_video_review_open"
                   class="button" data-type="inline"><span
                            class="ti-control-play"></span><?php esc_html_e('Video Review', 'grandcarrental'); ?></a>

                <div id="video_review<?php echo esc_attr($current_page_id); ?>" class="car_video_review_wrapper"
                     style="display:none;"><?php echo $car_video_review; ?></div>
                <?php
            }
            ?>
        </div>
    </div>

    <div class="single_car_header_content">
        <div class="standard_wrapper">
            <div class="single_car_header_price">
                <span id="single_car_price"><span class="single_car_price"><?php echo $vehicle->rate()->getDailyRateAmountForDisplay(); ?></span></span>
                <span id="single_car_price_per_unit_change" class="single_car_price_per_unit">
					<span id="single_car_unit">/ Per Day</span>
				</span>
            </div>
        </div>
    </div>
</div>
<div id="page_content_wrapper"
     class="<?php if (!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if (!empty($pp_page_bg) && !empty($grandcarrental_topbar)) { ?>withtopbar <?php } ?><?php if (!empty($grandcarrental_page_content_class)) {
         echo esc_attr($grandcarrental_page_content_class);
     } ?>">