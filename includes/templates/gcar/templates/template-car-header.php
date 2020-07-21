<script src="https://kit.fontawesome.com/d2b6c51265.js" crossorigin="anonymous"></script>
<div id="page_caption"
     class="hasbg"
     style="background-image:url(<?php echo $vehicle->getCustomField('f294'); ?>);"
>

    <div class="single_car_header_button">
        <div class="standard_wrapper">
        </div>
    </div>

    <div class="single_car_header_content">
        <div class="standard_wrapper">
            <?php if($vehicle->rate()->getDailyRateAmountForDisplay()): ?>
                <div class="single_car_header_price">
                <span id="single_car_price">
                    <span class="single_car_currency">R</span>
                    <span
                            class="single_car_price"><?php echo $vehicle->rate()->getFormattedMonthlyRate(0); ?></span></span>
                    <span id="single_car_price_per_unit_change" class="single_car_price_per_unit">
					<span id="single_car_unit">Per Month</span>
				</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div id="page_content_wrapper">