<?php
$tables = array(
	'bitforums' => "
		bitforum_id I4 PRIMARY,
		content_id I4 NOTNULL,
		description C(255)
	",
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
	'bit_bitforum_id_seq' => array( 'start' => 1 )
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
