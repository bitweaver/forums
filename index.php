<?php
// $Header: /cvsroot/bitweaver/_bit_forums/index.php,v 1.4 2006/06/16 22:26:15 spiderr Exp $
// Copyright (c) 2004 bitweaver BitForum
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// Initialization
require_once( '../bit_setup_inc.php' );
require_once( BITFORUM_PKG_PATH.'BitForum.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage( 'bitforum' );

// Now check permissions to access this page
$gBitSystem->verifyPermission( 'p_bitforum_read' );

/* mass-remove:
	the checkboxes are sent as the array $_REQUEST["checked[]"], values are the wiki-PageNames,
	e.g. $_REQUEST["checked"][3]="HomePage"
	$_REQUEST["submit_mult"] holds the value of the "with selected do..."-option list
	we look if any page's checkbox is on and if remove_bitforums is selected.
	then we check permission to delete bitforums.
	if so, we call histlib's method remove_all_versions for all the checked bitforums.
*/

require_once( BITFORUM_PKG_PATH.'lookup_bitforum_inc.php' );

if( $gContent->isValid() ) {
	$gForum->addHit();
	$comments_vars = Array( 'bitforumtopic' );
	$comments_prefix_var='bitforumtopic:';
	$comments_object_var='bitforumtopic';
	$commentsParentId = $gContent->mContentId;
	$comments_return_url = $_SERVER['PHP_SELF']."?t=".$gContent->getField('bitforum_topic_id');
	include_once( LIBERTY_PKG_PATH.'comments_inc.php' );
	$gBitSystem->display( 'bitpackage:bitforum/bitforum_topic_display.tpl', tra( 'Forum Topic' ).': '.$gForum->getTitle() );
} elseif( $gForum->isValid() ) {
	$gForum->addHit();
	$gBitSystem->display( 'bitpackage:bitforum/bitforum_display.tpl', tra( 'Forum' ).': '.$gForum->getTitle() );
} else {
	$bitforumsList = $gForum->getList( $_REQUEST );
	$gBitSmarty->assign_by_ref( 'bitforumsList', $bitforumsList );
	
	// getList() has now placed all the pagination information in $_REQUEST['listInfo']
	$gBitSmarty->assign_by_ref( 'listInfo', $_REQUEST['listInfo'] );
	
	// Display the template
	$gBitSystem->display( 'bitpackage:bitforum/list_bitforums.tpl', tra( 'Forum' ) );
}


?>
