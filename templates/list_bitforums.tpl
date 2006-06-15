{* $Header: /cvsroot/bitweaver/_bit_forums/templates/list_bitforums.tpl,v 1.1 2006/06/15 22:27:17 spiderr Exp $ *}
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

			<table class="data">
				<tr>
					{if $gBitSystem->isFeatureActive( 'bitforum_list_bitforum_id' ) eq 'y'}
						<th>{smartlink ititle="BitForum Id" isort=bitforum_id offset=$control.offset iorder=desc idefault=1}</th>
					{/if}

					{if $gBitSystem->isFeatureActive( 'bitforum_list_title' ) eq 'y'}
						<th>{smartlink ititle="Title" isort=title offset=$control.offset}</th>
					{/if}

					{if $gBitSystem->isFeatureActive( 'bitforum_list_description' ) eq 'y'}
						<th>{smartlink ititle="Description" isort=description offset=$control.offset}</th>
					{/if}

					{if $gBitSystem->isFeatureActive( 'bitforum_list_data' ) eq 'y'}
						<th>{smartlink ititle="Text" isort=data offset=$control.offset}</th>
					{/if}

					{if $gBitUser->hasPermission( 'p_bitforum_remove' )}
						<th>{tr}Actions{/tr}</th>
					{/if}
				</tr>

				{foreach item=bitforum from=$bitforumsList}
					<tr class="{cycle values="even,odd"}">
						{if $gBitSystem->isFeatureActive( 'bitforum_list_bitforum_id' )}
							<td><a href="{$smarty.const.BITFORUM_PKG_URL}index.php?bitforum_id={$bitforum.bitforum_id|escape:"url"}" title="{$bitforum.bitforum_id}">{$bitforum.bitforum_id}</a></td>
						{/if}

						{if $gBitSystem->isFeatureActive( 'bitforum_list_title' )}
							<td>{$bitforum.title|escape}</td>
						{/if}

						{if $gBitSystem->isFeatureActive( 'bitforum_list_description' )}
							<td>{$bitforum.description|escape}</td>
						{/if}

						{if $gBitSystem->isFeatureActive( 'bitforum_list_data' )}
							<td>{$bitforum.data|escape}</td>
						{/if}

						{if $gBitUser->hasPermission( 'p_bitforum_remove' )}
							<td class="actionicon">
								{smartlink ititle="Edit" ifile="edit.php" ibiticon="liberty/edit" bitforum_id=$bitforum.bitforum_id}
							</td>
						{/if}
					</tr>
				{foreachelse}
					<tr class="norecords"><td colspan="16">
						{tr}No records found{/tr}
					</td></tr>
				{/foreach}
			</table>

		{/form}

		{pagination}
	</div><!-- end .body -->
</div><!-- end .admin -->
{/strip}
