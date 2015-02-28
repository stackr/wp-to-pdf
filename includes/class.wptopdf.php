<?php
class WpToPdf{
	function __construct(){
		add_action( 'admin_menu', array(&$this, 'setting_menu') );
		add_filter('the_content',array(&$this,'h_wp_to_pdf'));
		add_action( 'admin_init',array(&$this,'register_setting') );
	}
	function setting_menu(){
		add_options_page( 'wp_to_pdf', __('WP to PDF','hotpack'), 10, basename(__FILE__), array(&$this,'wp_to_pdf_option_page') );
	}
	function wp_to_pdf_option_page(){
		require_once(dirname(dirname(__FILE__)).'/html/wp_to_pdf_option_page.php');
	}
	function register_setting(){
		register_setting( 'wp-to-pdf', 'wp_to_pdf' );
	}
	function h_wp_to_pdf($content){ //pdf 다운받기 버튼 생성
		$wp_to_pdf = get_option('wp_to_pdf');
		$authority =  isset($wp_to_pdf['authority']) ? $wp_to_pdf['authority'] : 'all';
		if($authority == 'all' || (is_user_logged_in() && is_super_admin(get_current_user_id()))):
		ob_start();
	?>
		<script type="text/javascript">
			function pdf_export(post_id){
				location.href='<?php echo plugins_url("hotpack");?>/modules/wp-to-pdf/pdf-write.php?post_id='+post_id;
			}
		</script>
		<input type="button" name="pdf_export" value="PDF로 다운받기" onclick="pdf_export(<?php echo get_the_ID();?>)" />
	<?php
		$wp_to_pdf = ob_get_contents();
		ob_end_clean();
		return $content."<p>".$wp_to_pdf."</p>";
		endif;
		return $content;
	}
}