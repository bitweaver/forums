<?php
/**
* $Header$
* $Id$
*/

/**
* BitForumTopic class to illustrate best practices when creating a new bitweaver package that
* builds on core bitweaver functionality, such as the Liberty CMS engine
*
* @date created 2004/8/15
* @author spider <spider@steelsun.com>
* @version $Revision$
* @class BitForumTopic
*/

require_once( LIBERTY_PKG_PATH.'LibertyAttachable.php' );

/**
* This is used to uniquely identify the object
*/
define( 'BITFORUMTOPIC_CONTENT_TYPE_GUID', 'bitforumtopic' );

class BitForumTopic extends LibertyAttachable {
	/**
	* Primary key for our mythical BitForumTopic class object & table
	* @public
	*/
	var $mBitForumTopicId;

	/**
	* During initialisation, be sure to call our base constructors
	**/
	function BitForumTopic( $pBitForumTopicId=NULL, $pContentId=NULL ) {
		LibertyAttachable::LibertyAttachable();
		$this->mBitForumTopicId = $pBitForumTopicId;
		$this->mContentId = $pContentId;
		$this->mContentTypeGuid = BITFORUMTOPIC_CONTENT_TYPE_GUID;
		$this->registerContentType( BITFORUMTOPIC_CONTENT_TYPE_GUID, array(
			'content_type_guid' => BITFORUMTOPIC_CONTENT_TYPE_GUID,
			'content_description' => 'BitForumTopic package with bare essentials',
			'handler_class' => 'BitForumTopic',
			'handler_package' => 'bitforum',
			'handler_file' => 'BitForumTopic.php',
			'maintainer_url' => 'http://www.bitweaver.org'
		) );
	}

	/**
	* Load the data from the database
	* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	**/
	function load() {
		if( $this->verifyId( $this->mBitForumTopicId ) || $this->verifyId( $this->mContentId ) ) {
			// LibertyContent::load()assumes you have joined already, and will not execute any sql!
			// This is a significant performance optimization
			$lookupColumn = $this->verifyId( $this->mBitForumTopicId ) ? 'bitforum_topic_id' : 'content_id';
			$bindVars = array();
			$selectSql = $joinSql = $whereSql = '';
			array_push( $bindVars, $lookupId = @BitBase::verifyId( $this->mBitForumTopicId ) ? $this->mBitForumTopicId : $this->mContentId );
			$this->getServicesSql( 'content_load_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

			$query = "SELECT bft.*, lc.*, uue.`login` AS modifier_user, uue.`real_name` AS modifier_real_name, uuc.`login` AS creator_user, uuc.`real_name` AS creator_real_name $selectSql 
			FROM `".BIT_DB_PREFIX."bitforums_topics` bft 
				INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = bft.`content_id` ) $joinSql
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uue ON( uue.`user_id` = lc.`modifier_user_id` )
				LEFT JOIN `".BIT_DB_PREFIX."users_users` uuc ON( uuc.`user_id` = lc.`user_id` )
			WHERE bft.`$lookupColumn`=? $whereSql";
			$result = $this->mDb->query( $query, $bindVars );

			if( $result && $result->numRows() ) {
				$this->mInfo = $result->fields;
				$this->mContentId = $result->fields['content_id'];
				$this->mBitForumTopicId = $result->fields['bitforum_topic_id'];

				$this->mInfo['creator'] =( isset( $result->fields['creator_real_name'] )? $result->fields['creator_real_name'] : $result->fields['creator_user'] );
				$this->mInfo['editor'] =( isset( $result->fields['modifier_real_name'] )? $result->fields['modifier_real_name'] : $result->fields['modifier_user'] );
				$this->mInfo['display_url'] = $this->getDisplayUrl();
				$this->mInfo['parsed_data'] = $this->parseData();

				LibertyAttachable::load();
			}
		}
		return( count( $this->mInfo ) );
	}

	/**
	* Any method named Store inherently implies data will be written to the database
	* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	* This is the ONLY method that should be called in order to store( create or update )an bitforum!
	* It is very smart and will figure out what to do for you. It should be considered a black box.
	*
	* @param array pParams hash of values that will be used to store the page
	*
	* @return bool TRUE on success, FALSE if store could not occur. If FALSE, $this->mErrors will have reason why
	*
	* @access public
	**/
	function store( &$pParamHash ) {
		$this->mDb->StartTrans();
		if( $this->verify( $pParamHash ) && LibertyAttachable::store( $pParamHash ) ) {
			$table = BIT_DB_PREFIX."bitforums_topics";
			if( $this->mBitForumTopicId ) {
				$result = $this->mDb->associateUpdate( $table, $pParamHash['topic_store'], array( "bitforum_topic_id" => $pParamHash['bitforum_topic_id'] ) );
			} else {
				$pParamHash['topic_store']['content_id'] = $pParamHash['content_id'];
				if( @$this->verifyId( $pParamHash['bitforum_id'] ) ) {
					// if pParamHash['bitforum_id'] is set, some is requesting a particular bitforum_id. Use with caution!
					$pParamHash['topic_store']['bitforum_topic_id'] = $pParamHash['bitforum_id'];
				} else {
					$pParamHash['topic_store']['bitforum_topic_id'] = $this->mDb->GenID( 'bitforums_topic_id_seq' );
				}
				$this->mBitForumTopicId = $pParamHash['topic_store']['bitforum_topic_id'];

				$result = $this->mDb->associateInsert( $table, $pParamHash['topic_store'] );
			}
		}
		$this->mDb->CompleteTrans();
		return( count( $this->mErrors ) == 0 );
	}

	/**
	* Make sure the data is safe to store
	* @param pParamHash be sure to pass by reference in case we need to make modifcations to the hash
	* This function is responsible for data integrity and validation before any operations are performed with the $pParamHash
	* NOTE: This is a PRIVATE METHOD!!!! do not call outside this class, under penalty of death!
	*
	* @param array pParams reference to hash of values that will be used to store the page, they will be modified where necessary
	*
	* @return bool TRUE on success, FALSE if verify failed. If FALSE, $this->mErrors will have reason why
	*
	* @access private
	**/
	function verify( &$pParamHash ) {
		global $gBitUser, $gBitSystem;

		// make sure we're all loaded up of we have a mBitForumTopicId
		if( $this->verifyId( $this->mBitForumTopicId ) && empty( $this->mInfo ) ) {
			$this->load();
		}

		if( @$this->verifyId( $this->mInfo['content_id'] ) ) {
			$pParamHash['content_id'] = $this->mInfo['content_id'];
		}

		// It is possible a derived class set this to something different
		if( @$this->verifyId( $pParamHash['content_type_guid'] ) ) {
			$pParamHash['content_type_guid'] = $this->mContentTypeGuid;
		}

		if( @$this->verifyId( $pParamHash['content_id'] ) ) {
			$pParamHash['topic_store']['content_id'] = $pParamHash['content_id'];
		}

		if( !empty( $pParamHash['data'] ) ) {
			$pParamHash['edit'] = $pParamHash['data'];
		}

		// check for name issues, first truncate length if too long
		if( !empty( $pParamHash['title'] ) ) {
			if( empty( $this->mBitForumTopicId ) ) {
				if( empty( $pParamHash['title'] ) ) {
					$this->mErrors['title'] = 'You must enter a name for this page.';
				} else {
					$pParamHash['content_store']['title'] = substr( $pParamHash['title'], 0, 160 );
				}
			} else {
				$pParamHash['content_store']['title'] =( isset( $pParamHash['title'] ) )? substr( $pParamHash['title'], 0, 160 ): '';
			}
		} else if( empty( $pParamHash['title'] ) ) {
			// no name specified
			$this->mErrors['title'] = 'You must specify a name';
		}

		// check for name issues, first truncate length if too long
		if( @$this->verifyId( $pParamHash['forum_id'] ) && $forumContentId = $this->mDb->getOne( "SELECT content_id FROM `".BIT_DB_PREFIX."bitforums` WHERE `bitforum_id`=?", array( $pParamHash['forum_id'] ) ) ) {
			$pParamHash['topic_store']['bitforum_content_id'] = $forumContentId;
		} else if( empty( $pParamHash['title'] ) ) {
			// no forum specified
			$this->mErrors['forum'] = 'You must specify a forum';
		}

		return( count( $this->mErrors )== 0 );
	}

	/**
	* This function removes a bitforum entry
	**/
	function expunge() {
		$ret = FALSE;
		if( $this->isValid() ) {
			$this->mDb->StartTrans();
			$query = "DELETE FROM `".BIT_DB_PREFIX."bitforums` WHERE `content_id` = ?";
			$result = $this->mDb->query( $query, array( $this->mContentId ) );
			if( LibertyAttachable::expunge() ) {
				$ret = TRUE;
				$this->mDb->CompleteTrans();
			} else {
				$this->mDb->RollbackTrans();
			}
		}
		return $ret;
	}

	/**
	* Make sure bitforum is loaded and valid
	**/
	function isValid() {
		return( $this->verifyId( $this->mBitForumTopicId ) );
	}

	/**
	* This function generates a list of records from the liberty_content database for use in a list page
	**/
	function getList( &$pParamHash ) {
		global $gBitSystem, $gBitUser;
		// this makes sure parameters used later on are set
		LibertyContent::prepGetList( $pParamHash );

		$selectSql = $joinSql = $whereSql = '';
		$bindVars = array();
		array_push( $bindVars, $this->mContentTypeGuid );
		$this->getServicesSql( 'content_list_sql_function', $selectSql, $joinSql, $whereSql, $bindVars );

		// this will set $find, $sort_mode, $max_records and $offset
		extract( $pParamHash );

		if( is_array( $find ) ) {
			// you can use an array of pages
			$whereSql .= " AND lc.`title` IN( ".implode( ',',array_fill( 0,count( $find ),'?' ) )." )";
			$bindVars = array_merge ( $bindVars, $find );
		} elseif( is_string( $find ) ) {
			// or a string
			$whereSql .= " AND UPPER( lc.`title` )like ? ";
			$bindVars[] = '%' . strtoupper( $find ). '%';
		}

		$query = "SELECT ts.*, lc.`content_id`, lc.`title`, lc.`data` $selectSql
			FROM `".BIT_DB_PREFIX."bitforums_topics` bft INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = bft.`content_id` ) $joinSql
			WHERE lc.`content_type_guid` = ? $whereSql
			ORDER BY ".$this->mDb->convert_sortmode( $sort_mode );
		$query_cant = "select count(*)
				FROM `".BIT_DB_PREFIX."bitforums_topics` bft INNER JOIN `".BIT_DB_PREFIX."liberty_content` lc ON( lc.`content_id` = ts.`content_id` ) $joinSql
			WHERE lc.`content_type_guid` = ? $whereSql";
		$result = $this->mDb->query( $query, $bindVars, $max_records, $offset );
		$ret = array();
		while( $res = $result->fetchRow() ) {
			$ret[] = $res;
		}
		$pParamHash["cant"] = $this->mDb->getOne( $query_cant, $bindVars );

		// add all pagination info to pParamHash
		LibertyContent::postGetList( $pParamHash );
		return $ret;
	}

	/**
	* Generates the URL to the bitforum page
	* @param pExistsHash the hash that was returned by LibertyContent::pageExists
	* @return the link to display the page.
	*/
	function getDisplayUrl() {
		$ret = NULL;
		if( @$this->verifyId( $this->mBitForumTopicId ) ) {
			$ret = BITFORUM_PKG_URL."index.php?t=".$this->mBitForumTopicId;
		}
		return $ret;
	}
}
?>
