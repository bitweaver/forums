<?php
global $gContent;
require_once( BITFORUM_PKG_PATH.'BitForum.php');
require_once( LIBERTY_PKG_PATH.'lookup_content_inc.php' );

// if we already have a gContent, we assume someone else created it for us, and has properly loaded everything up.
if( empty( $gContent ) || !is_object( $gContent ) || !$gContent->isValid() ) {
	// if bitforum_id supplied, use that
	if( @BitBase::verifyId( $_REQUEST['bitforum_id'] ) ) {
		$gContent = new BitForum( $_REQUEST['bitforum_id'] );

	// if content_id supplied, use that
	} elseif( @BitBase::verifyId( $_REQUEST['content_id'] ) ) {
		$gContent = new BitForum( NULL, $_REQUEST['content_id'] );

	} elseif (@BitBase::verifyId( $_REQUEST['bitforum']['bitforum_id'] ) ) {
		$gContent = new BitForum( $_REQUEST['bitforum']['bitforum_id'] );

	// otherwise create new object
	} else {
		$gContent = new BitForum();
	}

	$gContent->load();
	$gBitSmarty->assign_by_ref( "gContent", $gContent );
}
?>
