<?php
// $Header: /cvsroot/bitweaver/_bit_forums/admin/admin_bitforum_inc.php,v 1.1 2006/06/15 22:27:17 spiderr Exp $
// Copyright (c) 2005 bitweaver BitForum
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// is this used?
//if (isset($_REQUEST["bitforumset"]) && isset($_REQUEST["homeBitForum"])) {
//	$gBitSystem->storeConfig("home_bitforum", $_REQUEST["homeBitForum"]);
//	$gBitSmarty->assign('home_bitforum', $_REQUEST["homeBitForum"]);
//}

require_once( BITFORUM_PKG_PATH.'BitBitForum.php' );

$formBitForumLists = array(
	"bitforum_list_bitforum_id" => array(
		'label' => 'Id',
		'note' => 'Display the bitforum id.',
	),
	"bitforum_list_title" => array(
		'label' => 'Title',
		'note' => 'Display the title.',
	),
	"bitforum_list_description" => array(
		'label' => 'Description',
		'note' => 'Display the description.',
	),
	"bitforum_list_data" => array(
		'label' => 'Text',
		'note' => 'Display the text.',
	),
);
$gBitSmarty->assign( 'formBitForumLists',$formBitForumLists );

$processForm = set_tab();

if( $processForm ) {
	$bitforumToggles = array_merge( $formBitForumLists );
	foreach( $bitforumToggles as $item => $data ) {
		simple_set_toggle( $item, 'bitforums' );
	}

}

$bitforum = new BitBitForum();
$bitforums = $bitforum->getList( $_REQUEST );
$gBitSmarty->assign_by_ref('bitforums', $bitforums['data']);
?>
