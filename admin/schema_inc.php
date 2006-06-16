<?php
$tables = array(
	'bitforums' => "
		bitforum_id I4 PRIMARY,
		content_id I4 NOTNULL,
		description C(255)
	",
	'bitforums_topics' => "
		bitforum_topic_id I4 PRIMARY,
		bitforum_content_id I4 NOTNULL,
		content_id I4 NOTNOTULL,
		related_content_id I4
		CONSTRAINT ', CONSTRAINT `bitforums_topics_forum_ref` FOREIGN KEY (`bitforum_content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content` (`content_id`)
					, CONSTRAINT `bitforums_topics_related_ref` FOREIGN KEY (`related_content_id`) REFERENCES `".BIT_DB_PREFIX."liberty_content` (`content_id`)'
	"
);

global $gBitInstaller;

$gBitInstaller->makePackageHomeable( BITFORUM_PKG_NAME );

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( BITFORUM_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( BITFORUM_PKG_NAME, array(
	'description' => "BitForum package to demonstrate how to build a bitweaver package.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Indexes
$indices = array(
	'bit_bitforums_bitforum_id_idx' => array('table' => 'bitforums', 'cols' => 'bitforum_id', 'opts' => NULL ),
);
$gBitInstaller->registerSchemaIndexes( BITFORUM_PKG_NAME, $indices );

// ### Sequences
$sequences = array (
	'bitforums_id_seq' => array( 'start' => 1 ),
	'bitforums_topic_id_seq' => array( 'start' => 1 ),
);
$gBitInstaller->registerSchemaSequences( BITFORUM_PKG_NAME, $sequences );



$gBitInstaller->registerSchemaDefault( BITFORUM_PKG_NAME, array(
	//      "INSERT INTO `".BIT_DB_PREFIX."bit_bitforum_types` (`type`) VALUES ('BitForum')",
) );

// ### Default UserPermissions
$gBitInstaller->registerUserPermissions( BITFORUM_PKG_NAME, array(
	array( 'p_bitforum_admin', 'Can admin bitforum', 'admin', BITFORUM_PKG_NAME ),
	array( 'p_bitforum_create', 'Can create a bitforum', 'admin', BITFORUM_PKG_NAME ),
	array( 'p_bitforum_edit', 'Can edit any bitforum', 'admin', BITFORUM_PKG_NAME ),
	array( 'p_bitforum_read', 'Can read bitforum', 'basic',  BITFORUM_PKG_NAME ),
	array( 'p_bitforum_remove', 'Can delete bitforum', 'admin',  BITFORUM_PKG_NAME ),
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( BITFORUM_PKG_NAME, array(
	array( BITFORUM_PKG_NAME, 'bitforum_default_ordering', 'bitforum_id_desc' ),
	array( BITFORUM_PKG_NAME, 'bitforum_list_bitforum_id', 'y' ),
	array( BITFORUM_PKG_NAME, 'bitforum_list_title', 'y' ),
	array( BITFORUM_PKG_NAME, 'bitforum_list_description', 'y' ),
	array( BITFORUM_PKG_NAME, 'bitforum_list_bitforums', 'y' ),
) );
?>
