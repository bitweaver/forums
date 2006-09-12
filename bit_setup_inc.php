<?php
global $gBitSystem;

$registerHash = array(
	'package_name' => 'bitforum',
	'package_path' => dirname( __FILE__ ).'/',
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'bitforum' ) ) {
	$menuHash = array(
		'package_name'  => BITFORUM_PKG_NAME,
		'index_url'     => BITFORUM_PKG_URL.'index.php',
		'menu_template' => 'bitpackage:bitforum/menu_bitforum.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
}
?>
