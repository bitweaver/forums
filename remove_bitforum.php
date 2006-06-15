<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_forums/remove_bitforum.php,v 1.2 2006/06/15 22:42:31 spiderr Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: remove_bitforum.php,v 1.2 2006/06/15 22:42:31 spiderr Exp $
 * @package bitforum
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
include_once( BITFORUM_PKG_PATH.'BitForum.php');
include_once( BITFORUM_PKG_PATH.'lookup_bitforum_inc.php' );

$gBitSystem->verifyPackage( 'bitforum' );

if( !$gContent->isValid() ) {
	$gBitSystem->fatalError( "No bitforum indicated" );
}

$gBitSystem->verifyPermission( 'p_wiki_remove_bitforum' );

if( isset( $_REQUEST["confirm"] ) ) {
	if( $gContent->expunge()  ) {
		header ("location: ".BIT_ROOT_URL );
		die;
	} else {
		vd( $gContent->mErrors );
	}
}

$gBitSystem->setBrowserTitle( tra( 'Confirm delete of: ' ).$gContent->getTitle() );
$formHash['remove'] = TRUE;
$formHash['bitforum_id'] = $_REQUEST['bitforum_id'];
$msgHash = array(
	'label' => tra( 'Delete BitForum' ),
	'confirm_item' => $gContent->getTitle(),
	'warning' => tra( 'This bitforum will be completely deleted.<br />This cannot be undone!' ),
);
$gBitSystem->confirmDialog( $formHash,$msgHash );

?>
