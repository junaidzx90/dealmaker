<?php
global $wpdb;
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

$title = '';
$subtitle = '';
$description = '';
$logourl = '';
$badgeurl = '';
$disclaimer = '';

$result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}dealmaker WHERE ID = $makerId");
if($result){
    $title = $result->title;
    $subtitle = $result->subtitle;
    $description = $result->description;
    $logourl = $result->logo_url;
    $badgeurl = $result->badge_url;
    $disclaimer = $result->disclaimer;
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="deal_maker">
    <!-- Wrapping contents -->
    <section class="deal_maker_content_wrapper">
        <!-- Add headings -->
        <h1 class="deal_maker_headingOne"><?php echo __($title, 'dealmaker') ?></h1>
        <h4 class="deal_maker_headingTwo"><?php echo __($subtitle, 'dealmaker') ?></h4>

        <!-- Adding description -->
        <div class="deal_maker_description"><?php echo __(wpautop( $description ), 'dealmaker') ?></div>

        <!-- Adding information form -->
        <div id="informations">
            <div id="form_data">
                <label for="dm-logo">Upload a logo</label>
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
                <?php echo __(wpautop( $disclaimer ), 'dealmaker') ?>
            </div>

            <!-- Adding generate badge button -->
            <button id="deal_maker_generate_btn" class="deal_maker_generate_btn">Generate badge</button>
        </div>
    </section>

    <!-- Wrapping badge section -->
    <section class="deal_maker_badge_wrapper">
        <div class="deal_maker_badge_align">
            <div style="background-image: url(<?php echo $badgeurl ?>)" class="deal_maker_badge_preview" id="dealmaker_badge">
                <img src="" class="template__logo">

                <div class="badge_contents">
                    <div class="user-log-box" id="user-logo">
                        <img class="dealmaker_logo_url" src="<?php echo $logourl ?>">
                    </div>
                    <div id="dlinfo" class="info">
                        <div class="fullname-info-text">
                            <span class="fname-info-text">Mr</span>
                            <span class="lname-info-text">Jhon</span>
                        </div>
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