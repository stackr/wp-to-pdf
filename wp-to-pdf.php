<?php
/*
 * Plugin Name: PDF발행
 * Plugin URI: http://wordpress.org/extend/plugins/stackrpack/
 * Description: 포스팅한 내용을 PDF 파일로 변환해 줍니다. 관리자만 변환하고 다운 받을 수 있게 설정도 가능합니다.
 * Author: Stackr Inc.
 * Version: 1.0
 * Author URI: http://www.stackr.co.kr
 * License: GPL2+
 * Text Domain: hotpack
 * Domain Path: /languages/
 */
if(!class_exists('WpToPdf')){
	require_once(dirname(__FILE__).'/includes/class.wptopdf.php');
	new WpToPdf();
}
?>