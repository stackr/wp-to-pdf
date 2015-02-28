<div class="wrap hotpack_admin">
	<h2><?php echo __('WP to PDf Settings','hotpack');?></h2>
	<form action="options.php" method="post">
		<?php settings_fields( 'wp-to-pdf' );?>
		<?php
		$wp_to_pdf = get_option('wp_to_pdf');
		$authority =  isset($wp_to_pdf['authority']) ? $wp_to_pdf['authority'] : 'all';
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="authority"><?php echo __('Authority','hotpack');?></label></th>
					<td>
						<select name="wp_to_pdf[authority]" type="text" id="authority" class="postform">
							<option value='all'<?php selected( $authority, 'all' );?>><?php _e('All','hotpack');?></option>
							<option value='administrator'<?php selected( $authority, 'administrator' );?>><?php _e('Administrator','hotpack');?></option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button();?>
	</form>
</div>