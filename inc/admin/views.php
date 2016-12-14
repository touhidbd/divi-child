<?php
/*
	Divi Child Theme view settings
    */

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	// ***************************************
	// start settings ****************
	// ***************************************
?>

        <div class="">
            <!-- <h3 style="cursor:default;">Settings</h3> -->
            <div id="wpdc" class="inside" style="padding:0px 6px 0px 6px;">

			<!-- Table Structure Containing Form Controls -->
			<!-- Each Plugin Option Defined on a New Table Row -->
			<table class="form-table">
            	
                <tr valign="top">
					<th scope="row">Enabled Post Types</th>
					<td>
                    
                    	<?php 
						echo '<p>Check each post type that you would like the Divi Page Builder to appear on.</p>';
						echo '<span class="description">Note that the <strong>page</strong> and <strong>project</strong> types are always enabled ',
								'since they are hard-coded into the Divi Page Builder.</span>';
						echo '<br />';
						echo '<br />';
		
						// builtin types needed
						$builtin = array(
							'post',
							'page',
						);
						
						// all CPTs.
						$cpts = get_post_types( array(
							'public'   => true,
							'_builtin' => false
						) );
						
						// merge Builtin types and 'important' CPTs to resulting array to use as argument.
						$post_types = array_merge($builtin, $cpts);
						
						// display fields
						foreach ($post_types as $post_type) {

		    				if ($post_type == 'page' || $post_type == 'project') {
								echo "<label><input name='wpdc_options[".$post_type."]' type='checkbox' value='1' checked='checked' disabled='disabled' />".$post_type."</label>";
							} else {
								echo "<label><input name='wpdc_options[".$post_type."]' type='checkbox' value='1' ".checked('1', isset($options[$post_type]), false)."' />".$post_type."</label>";
							}
							echo '<br />';
						}
							
						echo '<br />';
                    	?>
                       
                    </td>
				</tr>
                <?php /*
                <tr valign="top">
					<th scope="row">Footer attributes</th>
					<td>
                    	<?php $wpdc_placeholder = 'Copyright © 2014 · '.get_bloginfo('name').' · all rights reserved.'; ?>
                        <textarea name="wpdc_options[wpdc_footer_attributes]" placeholder="<?php echo $wpdc_placeholder; ?>" rows="3" cols="50"><?php
							if (isset($options['wpdc_footer_attributes'])) {echo $options['wpdc_footer_attributes'];}
						?></textarea>
                        <br /><span class="description">Enter footer attributes, you can use HTML.</span>
				    </td>
				</tr>
                
                 <!-- Checkbox Buttons -->
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<!-- First checkbox button -->
						<label><input name="wpdc_options[wpdc_chk_content]" type="checkbox" value="1" <?php if (isset($options['wpdc_chk_content'])) { checked('1', $options['wpdc_chk_content']); } ?> /> Enable on full content?<br /><span class="description">Check this box if you would like to enable the add-on on full content.</span></label>
				    
                    </td>
				</tr>
                
                 <!-- Checkbox Buttons -->
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<!-- First checkbox button -->
						<label><input name="wpdc_options[wpdc_chk_excerpt]" type="checkbox" value="1" <?php if (isset($options['wpdc_chk_excerpt'])) { checked('1', $options['wpdc_chk_excerpt']); } ?> /> Enable on excerpt?<br /><span class="description">Check this box if you would like to enable the add-on on excerpt.</span></label>
				    
                    </td>
				</tr>
				*/ ?>
                
			</table>
            
			<p>
            	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>">
            	
			</p>
		        
               
            </div>
 
        </div><!-- end of general settings -->

