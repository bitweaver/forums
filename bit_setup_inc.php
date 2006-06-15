<?php
global $gBitSystem;

$registerHash = array(
	'package_name' => 'bitforum',
	'package_path' => dirname( __FILE__ ).'/',
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'bitforum' ) ) {
	$gBitSystem->registerAppMenu( BITFORUM_PKG_NAME, ucfirst( BITFORUM_PKG_DIR ), BITFORUM_PKG_URL.'index.php', 'bitpackage:bitforum/menu_bitforum.tpl', BITFORUM_PKG_NAME );
}
?>
