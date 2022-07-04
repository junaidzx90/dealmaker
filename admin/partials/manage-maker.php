<h3>Edit maker</h3>
<hr>

<?php
global $wpdb;
if(isset($_POST['save_dealmaker'])){
    $title = ((isset($_POST['maker_title'])) ? sanitize_text_field( $_POST['maker_title'] ): '');
    $subtitle = ((isset($_POST['maker_subtitle'])) ? sanitize_text_field ($_POST['maker_subtitle'] ): '');
    $description = ((isset($_POST['description'])) ? stripslashes($_POST['description']): '');
    $logourl = ((isset($_POST['logourl'])) ? esc_url_raw( $_POST['logourl'] ): '');
    $badgeurl = ((isset($_POST['badgeurl'])) ? esc_url_raw ($_POST['badgeurl'] ): '');
    $disclaimer = ((isset($_POST['disclaimer'])) ? stripslashes($_POST['disclaimer']): '');
    
    $wpdb->insert($wpdb->prefix.'dealmaker', array(
        'title' => $title,
        'subtitle' => $subtitle,
        'logo_url' => $logourl,
        'badge_url' => $badgeurl,
        'description' => $description,
        'disclaimer' => $disclaimer,
        'date' => date("Y-m-d h:i:s a")
    ));

    if($wpdb->insert_id){
        $lastid = $wpdb->insert_id;
        ob_start();
        wp_safe_redirect( admin_url( "admin.php?page=dealmaker&action=manage&maker=$lastid") );
        exit;
    }
}

if(isset($_POST['update_dealmaker'])){
    $title = ((isset($_POST['maker_title'])) ? sanitize_text_field( $_POST['maker_title'] ): '');
    $subtitle = ((isset($_POST['maker_subtitle'])) ? sanitize_text_field ($_POST['maker_subtitle'] ): '');
    $description = ((isset($_POST['description'])) ? stripslashes($_POST['description']): '');
    $logourl = ((isset($_POST['logourl'])) ? esc_url_raw( $_POST['logourl'] ): '');
    $badgeurl = ((isset($_POST['badgeurl'])) ? esc_url_raw ($_POST['badgeurl'] ): '');
    $disclaimer = ((isset($_POST['disclaimer'])) ? stripslashes($_POST['disclaimer']): '');
    
    $wpdb->update($wpdb->prefix.'dealmaker', array(
        'title' => $title,
        'subtitle' => $subtitle,
        'logo_url' => $logourl,
        'badge_url' => $badgeurl,
        'description' => $description,
        'disclaimer' => $disclaimer
    ), array("ID" => $manage_maker), array("%s","%s","%s","%s","%s","%s"), array("%d"));
}

$title = '';
$subtitle = '';
$description = '';
$logourl = '';
$badgeurl = '';
$disclaimer = '';

if(isset($manage_maker)){
    $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}dealmaker WHERE ID = $manage_maker");
    if($result){
        $title = $result->title;
        $subtitle = $result->subtitle;
        $description = $result->description;
        $logourl = $result->logo_url;
        $badgeurl = $result->badge_url;
        $disclaimer = $result->disclaimer;
    }
}
?>

<form id="dealmaker" method="post">
    <div class="_info_box">
        <label for="title_text">Title</label>
        <input type="text" id="title_text" name="maker_title" class="widefat" value="<?php echo $title ?>">
    </div>
    <div class="_info_box">
        <label for="subtitle">Subtitle</label>
        <input type="text" id="subtitle" name="maker_subtitle" class="widefat" value="<?php echo $subtitle ?>">
    </div>
    <div class="_info_box">
        <label for="description">Description</label>
        <?php
        wp_editor( wpautop( $description ), 'description', [
			'media_buttons' => false,
			'editor_height' => 200,
			'textarea_name' => 'description'
		] );
        ?>
    </div>
    <div class="_info_box">
        <label for="logourl">Logo URL</label>
        <input type="url" name="logourl" id="logourl" class="widefat" value="<?php echo $logourl ?>">
    </div>
    <div class="_info_box">
        <label for="badgeurl">Badge URL</label>
        <input type="url" name="badgeurl" id="badgeurl" class="widefat" value="<?php echo $badgeurl ?>">
    </div>
    <div class="_info_box">
        <label for="disclaimer">Disclaimer</label>
        <?php
        wp_editor( wpautop( $disclaimer ), 'disclaimer', [
			'media_buttons' => false,
			'editor_height' => 200,
			'textarea_name' => 'disclaimer'
		] );
        ?>
    </div>

    <div class="_info_box">
        <?php
        if(isset($manage_maker)){
            echo '<input type="submit" class="button-primary" name="update_dealmaker">';
        }else{
            echo '<input type="submit" class="button-primary" name="save_dealmaker">';
        }
        ?>
        
    </div>
</form>