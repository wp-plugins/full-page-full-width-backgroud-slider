<?php
/*
Plugin Name:Full Width Background Slider
Plugin URI: http://www.wpfruits.com/downloads/wp-plugins/full-page-full-width-background-slider-plugin-for-wordpress/
Description: This plugin will generate full width background slider for individual page and post with the help of custom fields..
Author: Nishant Jain, rahulbrilliant2004, tikendramaitry
Version: 1.0.3
Author URI: http://www.wpfruits.com/
*/
// ----------------------------------------------------------------------------------

// ADD Styles and Script in head section
add_action('admin_init', 'fwbslider_backend_scripts');
add_action('init', 'fwbslider_frontend_scripts');

function fwbslider_backend_scripts() {
	if(is_admin()){
		wp_enqueue_script ('jquery');
		wp_enqueue_script( 'fwbslider_backend_scripts',plugins_url('admin/fwbslider_admin.js',__FILE__), array('jquery'));
		wp_enqueue_style( 'fwbslider_backend_scripts',plugins_url('admin/fwbslider_admin.css',__FILE__), false, '1.0.0' );
	}
}

function fwbslider_frontend_scripts() {	
	if(!is_admin()){
		wp_enqueue_script('jquery');
		wp_enqueue_script('fwbslider',plugins_url('js/fwbslider.js',__FILE__), array('jquery'));
		wp_enqueue_style('fwbslider',plugins_url('css/fwbslider.css',__FILE__));
	}
}
//--------------------------------------------------------------------------------------------------------------------------------------




//---------------------------------------------------------------------------------------------------------------------------------------
//------------------- MAIN ADMIN MENU OPTIONS -------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
add_action('admin_menu', 'fwbslider_plugin_admin_menu');
function fwbslider_plugin_admin_menu() {
     add_menu_page('fwbslider', 'FWB Slider','administrator', 'fwbslider', 'fwbslider_backend_menu', plugins_url('images/icon.png',__FILE__));
}

//This function will create new database fields with default values
function fwbslider_defaults(){
	    $default = array(
		'fwbslide1' => plugins_url('images/slide1.jpg',__FILE__),
        'fwbslide2' => plugins_url('images/slide2.jpg',__FILE__),
    	'fwbslide3' => plugins_url('images/slide3.jpg',__FILE__),
		'fwbslide4' => plugins_url('images/slide4.jpg',__FILE__),
		'fwbslide5' => plugins_url('images/slide5.jpg',__FILE__),
		'fwbslide6' => plugins_url('images/slide6.jpg',__FILE__),
    );
return $default;
}

// Runs when plugin is activated and creates new database field
register_activation_hook(__FILE__,'fwbslider_plugin_install');
function fwbslider_plugin_install() {
    add_option('fwbslider_options', fwbslider_defaults());
}	

// update the fwbslider options
if(isset($_POST['fwbslider_update'])){
	update_option('fwbslider_options', fwbslider_updates());
}

function fwbslider_updates() {
	$options = $_POST['fwbslider_options'];
	    $update_val = array(
		'fwbslide1' => $options['fwbslide1'],
		'fwbslide2' => $options['fwbslide2'],
		'fwbslide3' => $options['fwbslide3'],
		'fwbslide4' => $options['fwbslide4'],
		'fwbslide5' => $options['fwbslide5'],
		'fwbslide6' => $options['fwbslide6'],
    );
return $update_val;
}

function fwbslider_backend_menu()
{
wp_nonce_field('update-options'); $options = get_option('fwbslider_options'); 
?>
	<div class="wrap">
	<div id="icon-themes" class="icon32"></div>
	<h2>Full Width Background Slider Setting</h2>
	</div>
	
	<div style="width:800px;">
		<div class="postbox" id="fwbslider_post_metas" style="padding:20px;margin-top:10px;">
			<span class="desc">Enter Slides URL :</span>
			<span class="desc">These Background Slides will work for all pages and posts until you have not checked option in post/page editor.</span>
			<form method="post" class="fwbslider_form">
				
				<table>
					<tr><th width="140px" align="right" ><label><?php _e('FWB Slide1 URL'); ?></label></th><td><input type="text" name="fwbslider_options[fwbslide1]" value="<?php echo $options['fwbslide1'] ?>" /></td></tr>
					<tr><th width="140px" align="right" ><label><?php _e('FWB Slide2 URL'); ?></label></th><td><input type="text" name="fwbslider_options[fwbslide2]" value="<?php echo $options['fwbslide2'] ?>" /></td></tr>
					<tr><th width="140px" align="right" ><label><?php _e('FWB Slide3 URL'); ?></label></th><td><input type="text" name="fwbslider_options[fwbslide3]" value="<?php echo $options['fwbslide3'] ?>" /></td></tr>
					<tr><th width="140px" align="right" ><label><?php _e('FWB Slide4 URL'); ?></label></th><td><input type="text" name="fwbslider_options[fwbslide4]" value="<?php echo $options['fwbslide4'] ?>" /></td></tr>
					<tr><th width="140px" align="right" ><label><?php _e('FWB Slide5 URL'); ?></label></th><td><input type="text" name="fwbslider_options[fwbslide5]" value="<?php echo $options['fwbslide5'] ?>" /></td></tr>
					<tr><th width="140px" align="right" ><label><?php _e('FWB Slide6 URL'); ?></label></th><td><input type="text" name="fwbslider_options[fwbslide6]" value="<?php echo $options['fwbslide6'] ?>" /></td></tr>
				   </table>	
	 
				<p class="button-controls">
					<input type="submit" value="<?php _e('Save') ?>" class="button-primary" id="fwbslider_update" name="fwbslider_update">	
				</p>
			</form>
		</div>
	</div>
<?php
}
//--------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------
//-------------------	POST AND PAGE BACKEND OPTIONS -----------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
// Hook for adding page/post custom mata boxes
add_action("admin_menu", "fwbslider_post_meta_box_options");
add_action('save_post', 'fwbslider_post_meta_box_save');

function fwbslider_post_meta_box_options(){
	if( function_exists( 'add_meta_box' ) ) {
		$post_types=get_post_types(); 
		foreach($post_types as $post_type) {
			add_meta_box("fwbslider_post_metas", "Full Width Background Slider Slides", "fwbslider_post_meta_box_add", $post_type, "normal", "high");
		}
	}
	else{
	}
}

function fwbslider_post_meta_box_add()
{
		global $post;
		$custom = get_post_custom($post->ID);
		$fwb_disable = $custom["fwb_disable"][0];
		$fwb_check = $custom["fwb_check"][0];
		$fwbslide1 = $custom["fwbslide1"][0];
		$fwbslide2 = $custom["fwbslide2"][0];
		$fwbslide3 = $custom["fwbslide3"][0];
		$fwbslide4 = $custom["fwbslide4"][0];
		$fwbslide5 = $custom["fwbslide5"][0];
		$fwbslide6 = $custom["fwbslide6"][0];

?>

	<div class="fwbslider_checkbox" style="margin-botom:5px;">
				<input type="checkbox" class="fwbslider_post" name="fwb_disable" id="fwb_disable" <?php if($fwb_disable){ ?> checked <?php } ?> value="true"/>&nbsp;
				<label for="fwb_disable" style="color:red;"><?php _e('Check this if you want to disable slider for this post/page.'); ?> </label>
	</div>

	<div class="fwbslider_disable">
	
		<div class="fwbslider_checkbox">
					<input type="checkbox" class="fwbslider_post" name="fwb_check" id="fwb_check" <?php if($fwb_check){ ?> checked <?php } ?> value="true"/>&nbsp;
					<label for="fwb_check"><?php _e('Add this post/page to "FWB Slider"..'); ?> </label>
		</div>
			
		<div class="fwbslider_table" >
		<table>
			<tr><th width="140px" align="right" ><label><?php _e('FWB Slide1 URL'); ?></label></th><td><input type="text" name="fwbslide1" value="<?php echo $fwbslide1; ?>" /></td></tr>
			<tr><th width="140px" align="right" ><label><?php _e('FWB Slide2 URL'); ?></label></th><td><input type="text" name="fwbslide2" value="<?php echo $fwbslide2; ?>" /></td></tr>
			<tr><th width="140px" align="right" ><label><?php _e('FWB Slide3 URL'); ?></label></th><td><input type="text" name="fwbslide3" value="<?php echo $fwbslide3; ?>" /></td></tr>
			<tr><th width="140px" align="right" ><label><?php _e('FWB Slide4 URL'); ?></label></th><td><input type="text" name="fwbslide4" value="<?php echo $fwbslide4; ?>" /></td></tr>
			<tr><th width="140px" align="right" ><label><?php _e('FWB Slide5 URL'); ?></label></th><td><input type="text" name="fwbslide5" value="<?php echo $fwbslide5; ?>" /></td></tr>
			<tr><th width="140px" align="right" ><label><?php _e('FWB Slide6 URL'); ?></label></th><td><input type="text" name="fwbslide6" value="<?php echo $fwbslide6; ?>" /></td></tr>
				<input type="hidden" name="meta_is_submit" value="yes" />
		   </table>	
		</div> 
		
	</div>
	
<?php
}


//update post custom fields
function fwbslider_post_meta_box_save($post_id)
{
	global $post;
	if(isset($_POST['meta_is_submit']))
	{
		update_post_meta($post_id, "fwb_disable",$_POST['fwb_disable']);
		update_post_meta($post_id, "fwb_check",$_POST['fwb_check']);
		update_post_meta($post_id, "fwbslide1",$_POST['fwbslide1']);
		update_post_meta($post_id, "fwbslide2",$_POST['fwbslide2']);
		update_post_meta($post_id, "fwbslide3",$_POST['fwbslide3']);
		update_post_meta($post_id, "fwbslide4",$_POST['fwbslide4']);
		update_post_meta($post_id, "fwbslide5",$_POST['fwbslide5']);
		update_post_meta($post_id, "fwbslide6",$_POST['fwbslide6']);
	}
}

//------------------------------------------------------------------------------------------------------------------------------------------

//------------- FUNCTION TO CALL SLIDER -------------------------------------------------------

add_action('wp_footer','fwbslider');
function fwbslider(){
		$options = get_option('fwbslider_options'); 
		global $post;
		$custom = get_post_custom($post->ID);
		$fwb_disable = $custom["fwb_disable"][0];
		$fwb_check = $custom["fwb_check"][0];
		$fwbslide1 = $custom["fwbslide1"][0];
		$fwbslide2 = $custom["fwbslide2"][0];
		$fwbslide3 = $custom["fwbslide3"][0];
		$fwbslide4 = $custom["fwbslide4"][0];
		$fwbslide5 = $custom["fwbslide5"][0];
		$fwbslide6 = $custom["fwbslide6"][0];
		
		$fwbslide1_all = $options["fwbslide1"];
		$fwbslide2_all = $options["fwbslide2"];
		$fwbslide3_all = $options["fwbslide3"];
		$fwbslide4_all = $options["fwbslide4"];
		$fwbslide5_all = $options["fwbslide5"];
		$fwbslide6_all = $options["fwbslide6"];
		
		$from_this = "http://www.wpfruits.com/downloads/wp-plugins/full-page-full-width-background-slider-plugin-for-wordpress/?utm_refs=".$_SERVER['SERVER_NAME'];

	if($fwb_check && !$fwb_disable){
	?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery.fwbslider('#fwbslider', {'delay':5000, 'fadeSpeed': 2000});
		});
	</script>
	<!-- FWB Slider Start here -->
	<div id="fwbslider" class="for_only">
			<?php if($fwbslide1){ ?><img src="<?php echo $fwbslide1; ?>" /><?php } ?>
			<?php if($fwbslide2){ ?><img src="<?php echo $fwbslide2; ?>" /><?php } ?>
			<?php if($fwbslide3){ ?><img src="<?php echo $fwbslide3; ?>" /><?php } ?>
			<?php if($fwbslide4){ ?><img src="<?php echo $fwbslide4; ?>" /><?php } ?>
			<?php if($fwbslide5){ ?><img src="<?php echo $fwbslide5; ?>" /><?php } ?>
			<?php if($fwbslide6){ ?><img src="<?php echo $fwbslide6; ?>" /><?php } ?>
	</div>
	<a class="fwb_fromthis" target="_blank" href="<?php echo $from_this; ?>" title=""><img src="<?php echo plugins_url('images/FWB-big.png',__FILE__) ?>" /></a>
	<!-- FWB Slider End here -->
	<?php
	}
	
	elseif(!$fwb_disable){
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery.fwbslider('#fwbslider', {'delay':5000, 'fadeSpeed': 2000});
			});
		</script>
		<!-- FWB Slider Start here -->
		<div id="fwbslider" class="for_all">
				<?php if($fwbslide1_all){ ?><img src="<?php echo $fwbslide1_all; ?>" /><?php } ?>
				<?php if($fwbslide2_all){ ?><img src="<?php echo $fwbslide2_all; ?>" /><?php } ?>
				<?php if($fwbslide3_all){ ?><img src="<?php echo $fwbslide3_all; ?>" /><?php } ?>
				<?php if($fwbslide4_all){ ?><img src="<?php echo $fwbslide4_all; ?>" /><?php } ?>
				<?php if($fwbslide5_all){ ?><img src="<?php echo $fwbslide5_all; ?>" /><?php } ?>
				<?php if($fwbslide6_all){ ?><img src="<?php echo $fwbslide6_all; ?>" /><?php } ?>
		</div>
		<a class="fwb_fromthis" target="_blank" href="<?php echo $from_this; ?>" title=""><img src="<?php echo plugins_url('images/FWB-big.png',__FILE__) ?>" /></a>
		<!-- FWB Slider End here -->
	<?php
	}
}
//----------------------------------------------------------------------------------------------------


?>