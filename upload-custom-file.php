<?php
/*
Plugin Name: Upload custom file
Plugin URI: https://decodecms.com
description: Demo plugin for uploading files with PHP
Version: 1.0
Author: Jhon Marreros
Author URI: https://decodecms.com
License: GPL2
*/

// Show Form
add_action( 'admin_menu', 'register_media_selector_settings_page' );

function register_media_selector_settings_page() {
	add_submenu_page( 'tools.php', 'Upload File', 'Upload File', 'manage_options', 'upload-file', 'dcms_upload_file_settings_callback' );
}

function dcms_upload_file_settings_callback() {
	?>
	<div class="wrap">
		<h1>Ejemplo de subida de archivo</h1>
		<br>
		<form enctype="multipart/form-data" method="post">
			Selecciona algún archivo: <input name="upload-file" type="file" /> <hr>
			<input type="submit" value="Enviar archivo" />
		</form>
	</div>
	<?php

	if(isset($_FILES['upload-file'])) {
		global $wp_filesystem;
		WP_Filesystem();

		$name_file = $_FILES['upload-file']['name'];
		$tmp_name = $_FILES['upload-file']['tmp_name'];
		$allow_extensions = ['xls', 'xlsx', 'csv'];

		// File type validation
		$path_parts = pathinfo($name_file);
		$ext = $path_parts['extension'];

		if ( ! in_array($ext, $allow_extensions) ) {
			echo "Error - File type not allowed";
			return;
		}

		$content_directory = $wp_filesystem->wp_content_dir() . 'uploads/archivos-subidos/';
		$wp_filesystem->mkdir( $content_directory );

		if( move_uploaded_file( $tmp_name, $content_directory . $name_file ) ) {
			echo "File was successfully uploaded";
		} else {
			echo "The file was not uploaded";
		}
	}
}
