<h3>Edit maker</h3>
<hr>

<?php
function upload_dealmaker_images($file, $filename){
    global $dealerror;
    $dealerror = '';

    $wpdir = wp_upload_dir(  );
    $max_upload_size = wp_max_upload_size();
    $fileSize = $file['size'];
    $imageFileType = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));

    $uploadPath = DEALMAKER_PATH."upload/$filename.$imageFileType";
    $uploadUrl = DEALMAKER_URL."upload/$filename.$imageFileType";

    // Allow certain file formats
    $allowedExt = array("jpg", "jpeg", "png", "PNG", "JPG", "gif");

    if(!in_array($imageFileType, $allowedExt)) {
        $dealerror = "Unsupported file format!";
    }

    if ($fileSize > $max_upload_size) {
        $dealerror = "Maximum upload size $max_upload_size";
    }

    if(empty($dealerror)){
        if(move_uploaded_file($file["tmp_name"], $uploadPath)){
            return $uploadUrl;
        }
    }
}

global $wpdb;
if(isset($_POST['save_dealmaker'])){
    $title = ((isset($_POST['maker_title'])) ? sanitize_text_field( $_POST['maker_title'] ): '');
    $subtitle = ((isset($_POST['maker_subtitle'])) ? sanitize_text_field ($_POST['maker_subtitle'] ): '');
    $description = ((isset($_POST['description'])) ? stripslashes($_POST['description']): '');
    $logoImage = ((isset($_FILES['logoImage'])) ? $_FILES['logoImage']: '');
    $badgeImage = ((isset($_FILES['badgeImage'])) ? $_FILES['badgeImage']: '');
    $disclaimer = ((isset($_POST['disclaimer'])) ? stripslashes($_POST['disclaimer']): '');

    $wpdb->insert($wpdb->prefix.'dealmaker', array(
        'title' => $title,
        'subtitle' => $subtitle,
        'description' => $description,
        'disclaimer' => $disclaimer,
        'date' => date("Y-m-d h:i:s a")
    ));

    if($wpdb->insert_id){
        $lastid = $wpdb->insert_id;
        $logoUrl = '';
        $badgeUrl = '';
        if(!empty($logoImage['tmp_name'])){
            $logoUrl = upload_dealmaker_images($logoImage, "logo-$lastid");
        }
        if(!empty($badgeImage['tmp_name'])){
            $badgeUrl = upload_dealmaker_images($badgeImage, "badge-$lastid"); 
        }

        $wpdb->update($wpdb->prefix.'dealmaker', array(
            'logo_url' => $logoUrl,
            'badge_url' => $badgeUrl,
        ), array("ID" => $lastid), array("%s","%s"), array("%d"));

        wp_safe_redirect( admin_url( "admin.php?page=dealmaker&action=manage&maker=$lastid") );
        exit;
    }
}

if(isset($_POST['update_dealmaker'])){
    $title = ((isset($_POST['maker_title'])) ? sanitize_text_field( $_POST['maker_title'] ): '');
    $subtitle = ((isset($_POST['maker_subtitle'])) ? sanitize_text_field ($_POST['maker_subtitle'] ): '');
    $description = ((isset($_POST['description'])) ? stripslashes($_POST['description']): '');
    $logoImage = ((isset($_FILES['logoImage'])) ? $_FILES['logoImage']: '');
    $badgeImage = ((isset($_FILES['badgeImage'])) ? $_FILES['badgeImage']: '');
    $disclaimer = ((isset($_POST['disclaimer'])) ? stripslashes($_POST['disclaimer']): '');

    $logoUrl = $wpdb->get_var("SELECT logo_url FROM {$wpdb->prefix}dealmaker WHERE ID = $manage_maker");
    $badgeUrl = $wpdb->get_var("SELECT badge_url FROM {$wpdb->prefix}dealmaker WHERE ID = $manage_maker");
    
    if(!empty($logoImage['tmp_name'])){
        $logoUrl = upload_dealmaker_images($logoImage, "logo-$manage_maker");
    }
    if(!empty($badgeImage['tmp_name'])){
        $badgeUrl = upload_dealmaker_images($badgeImage, "badge-$manage_maker"); 
    }
    

    $wpdb->update($wpdb->prefix.'dealmaker', array(
        'title' => $title,
        'subtitle' => $subtitle,
        'logo_url' => $logoUrl,
        'badge_url' => $badgeUrl,
        'description' => $description,
        'disclaimer' => $disclaimer
    ), array("ID" => $manage_maker), array("%s","%s","%s","%s","%s","%s"), array("%d"));
}

global $dealerror;
$title = '';
$subtitle = '';
$description = '';
$logoImage = '';
$badgeImage = '';
$disclaimer = '';

if(isset($manage_maker)){
    $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}dealmaker WHERE ID = $manage_maker");
    if($result){
        $title = $result->title;
        $subtitle = $result->subtitle;
        $description = $result->description;
        $logoImage = $result->logo_url;
        $badgeImage = $result->badge_url;
        $disclaimer = $result->disclaimer;
    }
}
?>

<?php echo $dealerror; ?>
<form id="dealmaker" method="post" enctype="multipart/form-data">
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
        <label for="logoImage">Logo Image</label>
        <div class="previewImage">
            <img src="<?php echo $logoImage ?>" width="200px">
        </div>
        <input type="file" name="logoImage" id="logoImage">
    </div>
    <div class="_info_box">
        <label for="badgeImage">Badge Image</label>
        <div class="previewImage">
            <img src="<?php echo $badgeImage ?>" width="200px">
        </div>
        <input type="file" name="badgeImage" id="badgeImage">
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