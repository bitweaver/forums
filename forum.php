<?php
// $Header: /cvsroot/bitweaver/_bit_forums/Attic/forum.php,v 1.1 2006/06/15 22:52:05 spiderr Exp $
// Copyright (c) 2004 bitweaver Sample
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'bitforum' );

// Now check permissions to access this page
$gBitSystem->verifyPermission( 'p_bitforum_read' );

if( !isset( $_REQUEST['bitforum_id'] ) ) {
	$_REQUEST['bitforum_id'] = $gBitSystem->getConfig( "home_bitforum" );
}

require_once( BITFORUM_PKG_PATH.'lookup_bitforum_inc.php' );

$gContent->addHit();

// Display the template
$gBitSystem->display( 'bitpackage:bitforum/bitforum_display.tpl', tra( 'Forum' ) );
?>
