{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='nav' serviceHash=$gForum->mInfo}
<div class="display bitforum">
	<div class="floaticon">
		{if $print_page ne 'y'}
			{if $gBitUser->hasPermission( 'p_bitforum_edit' )}
				<a title="{tr}Remove this bitforum{/tr}" href="{$smarty.const.BITFORUM_PKG_URL}edit.php?f={$gForum->mInfo.bitforum_id}">{biticon ipackage="icons" iname="accessories-text-editor" iexplain="Edit BitForum"}</a>
			{/if}
			{if $gBitUser->hasPermission( 'p_bitforum_remove' )}
				<a title="{tr}Remove this bitforum{/tr}" href="{$smarty.const.BITFORUM_PKG_URL}remove_bitforum.php?forum_id={$gForum->mInfo.bitforum_id}">{biticon ipackage="icons" iname="edit-delete" iexplain="Remove BitForum"}</a>
			{/if}
		{/if}<!-- end print_page -->
	</div><!-- end .floaticon -->

	<div class="header">
		<h1>{$gForum->mInfo.title|escape|default:"Forum"}</h1>
		<h2>{$gForum->mInfo.description|escape}</h2>
			{$gForum->mInfo.parsed_data}
		<div class="navbar">
			{smartlink ititle="Post New Thread" f=$gForum->mBitForumId ifile="post.php" }
		</div>
	</div><!-- end .header -->

	<div class="body">
		<div class="content">

			<ul class="data">
			{foreach from=$topics item=topic key=contentId}
				<li><a href="{$smarty.const.BITFORUM_PKG_URL}index.php?t={$topic.bitforum_topic_id}">{$topic.title}</a></li>
			{foreachelse}
				<li>No topics yet.</li>
			{/foreach}
			</ul>

		</div><!-- end .content -->
	</div><!-- end .body -->
</div><!-- end .bitforum -->
{include file="bitpackage:liberty/services_inc.tpl" serviceLocation='view' serviceHash=$gForum->mInfo}
