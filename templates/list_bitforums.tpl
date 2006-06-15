{* $Header: /cvsroot/bitweaver/_bit_forums/templates/list_bitforums.tpl,v 1.2 2006/06/15 22:52:05 spiderr Exp $ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="listing bitforum">
	<div class="header">
		<h1>{tr}Forums{/tr}</h1>
	</div>

	<div class="body">

		{form id="checkform"}
			<input type="hidden" name="offset" value="{$control.offset|escape}" />
			<input type="hidden" name="sort_mode" value="{$control.sort_mode|escape}" />

			<ul class="data">
				{foreach item=bitforum from=$bitforumsList}
					<li class="item {cycle values="even,odd"}">
						<h2><a href="{$smarty.const.BITFORUM_PKG_URL}forum.php?bitforum_id={$bitforum.bitforum_id|escape:"url"}" title="{$bitforum.bitforum_id}">{$bitforum.title|escape}</a></h2>
							<span>{$bitforum.description|escape}</span>

						{if $gBitUser->hasPermission( 'p_bitforum_edit' )}
							{smartlink ititle="Edit" class="actionicon" ifile="edit.php" ibiticon="liberty/edit" bitforum_id=$bitforum.bitforum_id}
						{/if}
					</li>
				{foreachelse}
					<li class="norecords">
						{tr}No records found{/tr}
					</li>
				{/foreach}
			</ul>

		{/form}

		{pagination}
	</div><!-- end .body -->
</div><!-- end .admin -->
{/strip}
