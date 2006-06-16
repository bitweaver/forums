{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='nav' serviceHash=$gContent->mInfo}
<div class="display bitforum">
	<div class="floaticon">
		{if $print_page ne 'y'}
			{if $gBitUser->hasPermission( 'p_bitforum_edit' )}
				<a title="{tr}Remove this bitforum{/tr}" href="{$smarty.const.BITFORUM_PKG_URL}edit.php?t={$gContent->mInfo.bitforum_topic_id}">{biticon ipackage=liberty iname="edit" iexplain="Edit BitForum"}</a>
			{/if}
			{if $gBitUser->hasPermission( 'p_bitforum_remove' )}
				<a title="{tr}Remove this bitforum{/tr}" href="{$smarty.const.BITFORUM_PKG_URL}remove_bitforum.php?forum_id={$gContent->mInfo.bitforum_id}">{biticon ipackage=liberty iname="delete" iexplain="Remove BitForum"}</a>
			{/if}
		{/if}<!-- end print_page -->
	</div><!-- end .floaticon -->

	<div class="navbar">
		{tr}Forums{/tr} &raquo;
	</div>
	
	<div class="header">
		<h1>{$gContent->getTitle()|escape|default:"Forum Topic"}</h1>
		<div class="date">
				{tr}Posted by{/tr}: {displayname user=$gContent->mInfo.creator_user user_id=$gContent->mInfo.creator_user_id real_name=$gContent->mInfo.creator_real_name} on {$gContent->getField('created')|bit_short_datetime}

				{if $gContent->getField('last_modified') != $gContent->getField('created')}
					<br/>{tr}Edited by{/tr}: {displayname user=$gContent->mInfo.modifier_user user_id=$gContent->mInfo.modifier_user_id real_name=$gContent->mInfo.modifier_real_name}, {$gContent->getField('last_modified')|bit_short_datetime}
				{/if}
		</div>

	</div><!-- end .header -->

	<div class="body">
		<div class="content">
			{$gContent->getField('parsed_data')}
		</div><!-- end .content -->
	</div><!-- end .body -->
</div><!-- end .bitforum -->
{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='view' serviceHash=$gContent->mInfo}
