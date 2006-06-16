<?php
global $gForum;
require_once( BITFORUM_PKG_PATH.'BitForum.php');
require_once( BITFORUM_PKG_PATH.'BitForumTopic.php');
require_once( LIBERTY_PKG_PATH.'lookup_content_inc.php' );

// Topics are gContent, forums and always gForum

// if we already have a gContent, we assume someone else created it for us, and has properly loaded everything up.
if( empty( $gContent ) || !is_object( $gContent ) || !$gContent->isValid() ) {
	// if bittopic_id supplied, use that
	if( @BitBase::verifyId( $_REQUEST['topic_id'] ) ) {
		$gContent = new BitForumTopic( $_REQUEST['topic_id'] );
	// if bittopic_id supplied, use that
	} elseif( @BitBase::verifyId( $_GET['t'] ) ) {
		$gContent = new BitForumTopic( $_REQUEST['t'] );
	// if content_id supplied, use that
	} elseif( @BitBase::verifyId( $_REQUEST['content_id'] ) ) {
		$gContent = new BitForumTopic( NULL, $_REQUEST['content_id'] );

	} elseif (@BitBase::verifyId( $_REQUEST['bitforum']['topic_id'] ) ) {
		$gContent = new BitForumTopic( $_REQUEST['bitforum']['topic_id'] );

	// otherwise create new object
	} else {
		$gContent = new BitForumTopic();
	}

	$gContent->load();
	$gBitSmarty->assign_by_ref( "gContent", $gContent );
}

// if we already have a gForum, we assume someone else created it for us, and has properly loaded everything up.
if( empty( $gForum ) || !is_object( $gForum ) || !$gForum->isValid() ) {
	// if bitforum_id supplied, use that
	if( @BitBase::verifyId( $_REQUEST['forum_id'] ) ) {
		$gForum = new BitForum( $_REQUEST['forum_id'] );
	// if bitforum_id supplied, use that
	} elseif( @BitBase::verifyId( $_GET['f'] ) ) {
		$gForum = new BitForum( $_REQUEST['f'] );
	// if content_id supplied, use that
	} elseif( @BitBase::verifyId( $_REQUEST['content_id'] ) ) {
		$gForum = new BitForum( NULL, $_REQUEST['content_id'] );

	} elseif (@BitBase::verifyId( $_REQUEST['bitforum']['forum_id'] ) ) {
		$gForum = new BitForum( $_REQUEST['bitforum']['forum_id'] );

	// otherwise create new object
	} else {
		$gForum = new BitForum();
	}

	$gForum->load();
	$gBitSmarty->assign_by_ref( "gForum", $gForum );
}

?>
