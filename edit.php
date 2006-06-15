<?php
// $Header: /cvsroot/bitweaver/_bit_forums/edit.php,v 1.1 2006/06/15 22:27:17 spiderr Exp $
// Copyright (c) 2004 bitweaver BitForum
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../bit_setup_inc.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'bitforum' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_bitforum_edit' );

require_once(BITFORUM_PKG_PATH.'lookup_bitforum_inc.php' );

if( isset( $_REQUEST['bitforum']["title"] ) ) {
	$gContent->mInfo["title"] = $_REQUEST['bitforum']["title"];
}

if( isset( $_REQUEST['bitforum']["description"] ) ) {
	$gContent->mInfo["description"] = $_REQUEST['bitforum']["description"];
}

if( isset( $_REQUEST["format_guid"] ) ) {
	$gContent->mInfo['format_guid'] = $_REQUEST["format_guid"];
}

if( isset( $_REQUEST['bitforum']["edit"] ) ) {
	$gContent->mInfo["data"] = $_REQUEST['bitforum']["edit"];
	$gContent->mInfo['parsed_data'] = $gContent->parseData();
}

// If we are in preview mode then preview it!
if( isset( $_REQUEST["preview"] ) ) {
	$gBitSmarty->assign('preview', 'y');
}

// Pro
// Check if the page has changed
if( !empty( $_REQUEST["save_bitforum"] ) ) {

	// Check if all Request values are delivered, and if not, set them
	// to avoid error messages. This can happen if some features are
	// disabled
	if( $gContent->store( $_REQUEST['bitforum'] ) ) {
		header( "Location: ".$gContent->getDisplayUrl() );
		die;
	} else {
		$gBitSmarty->assign_by_ref( 'errors', $gContent->mErrors );
	}
}

// Configure quicktags list
if( $gBitSystem->isPackageActive( 'quicktags' ) ) {
	include_once( QUICKTAGS_PKG_PATH.'quicktags_inc.php' );
}

// WYSIWYG and Quicktag variable
$gBitSmarty->assign( 'textarea_id', 'editbitforum' );

// Display the template
$gBitSystem->display( 'bitpackage:bitforum/edit_bitforum.tpl', tra('BitForum') );
?>
