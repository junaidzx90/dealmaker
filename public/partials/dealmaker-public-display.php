<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Dealmaker
 * @subpackage Dealmaker/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="deal_maker">
    <!-- Wrapping contents -->
    <section class="deal_maker_content_wrapper">
        <!-- Adding logo section -->
        <?php
        if(get_option('dealmaker_logo_url')){
            ?>
            <div class="deal_maker_logo">
                <img src="<?php echo get_option('dealmaker_logo_url') ?>">
            </div>
            <?php
        }
        ?>

        <!-- Add headings -->
        <h1 class="deal_maker_headingOne">Show the World <br> You're a DealMaker</h1>
        <h4 class="deal_maker_headingTwo">Download and share your custom DealMaker badge.</h4>

        <!-- Adding description -->
        <p class="deal_maker_description">You’re now registered to attend DealMaker so let the world know it! Create a custom badge by filling in the fields below and then click “Generate Badge.” Share the image on your social media to help you get a jump start on your networking for the event and start making some deals. We can’t wait to see you soon!</p>

        <!-- Adding information form -->
        <div id="informations">
            <div id="form_data">
                <label for="dm-logo">Upload a logo <sub>*</sub></label>
                <input type="file" id="dm-logo">
                <label for="dm-first-name">First name <sub>*</sub></label>
                <input type="text" id="dm-first-name">
                <label for="dm-last-name">Last name <sub>*</sub></label>
                <input type="text" id="dm-last-name">
                <label for="dm-jobtitle">Job title <sub>*</sub></label>
                <input type="text" id="dm-jobtitle">
                <label for="dm-company">Company <sub>*</sub></label>
                <input type="text" id="dm-company">
            </div>

            <!-- Adding richtexts -->
            <div class="deal_maker_richtext">
                <p>We store your email address (or personal data above) in our database so we can send you communications from us and our service providers related to the commercial relationship and transaction, industry news and information and/or programs of interest, or marketing and sales material. Please refer to our privacy policy for more information: <a href="<?php echo get_option('dealmaker_privacy_page_url') ?>"><?php echo get_option('dealmaker_privacy_page_url') ?></a>.</p>
                <p>You may unsubscribe or change your email address for email communications at any time by following the instructions mentioned prominently within each email communications or by emailing <a href="mailto:<?php echo get_option('dealmaker_support_mail') ?>"><?php echo get_option('dealmaker_support_mail') ?></a>.</p>
            </div>

            <!-- Adding generate badge button -->
            <button id="deal_maker_generate_btn" class="deal_maker_generate_btn">Generate badge</button>
        </div>
    </section>

    <!-- Wrapping badge section -->
    <section class="deal_maker_badge_wrapper">
        <div class="deal_maker_badge_align">
            <div style="background-image: url(<?php echo plugin_dir_url(__FILE__)."template.png" ?>)" class="deal_maker_badge_preview" id="dealmaker_badge">
                <img src="<?php echo get_option('dealmaker_logo_url') ?>" class="template__logo">

                <div class="badge_contents">
                    <div style="background-image: url(<?php echo get_option('dealmaker_logo_url') ?>)"  class="user-log-box" id="user-logo">
                    </div>
                    <div id="dlinfo" class="info">
                        <div class="fname-info-text"><span>First name</span></div>
                        <div class="lname-info-text"><span>Last name</span></div>
                        <div class="jobtitle-info-text"><span>Job title</span></div>
                        <div class="company-info-text"><span class="company">Company</span></div>
                    </div>
                </div>
            </div>
            
            <div class="generated_button none">
                <button id="deal_maker_download_btn" class="deal_maker_generate_btn">Download badge</button>

                <div class="dm-badge__loading">
                    <div></div>
                    <div></div>
                </div>

                <h5>Download it and share on your social media networks!</h5>
                <div class="social-media">

                    <a target="_blank" href="https://www.linkedin.com/feed/?shareActive=true" title="Share us on LinkedIn" class="linkedin-link"><i class="fab fa-linkedin-in"></i></a>

                    <a target="_blank" href="http://twitter.com/share" title="Share us on Twitter" class="twitter-link"><i class="fab fa-twitter"></i></a>

                    <a target="_blank" href="https://www.facebook.com/profile" data-scheme="fb://composer" title="Share us on Facebook" class="facebook-link"><i class="fab fa-facebook-f"></i></a>

                </div>
            </div>
        </div>
    </section>
</div>