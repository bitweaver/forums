{strip}
	<ul>
		{if $gBitUser->hasPermission( 'p_bitforum_read')}
			<li><a class="item" href="{$smarty.const.BITFORUM_PKG_URL}index.php">{tr}BitForums Home{/tr}</a></li>
		{/if}
		{if $gBitUser->hasPermission( 'p_bitforum_create' ) || $gBitUser->hasPermission( 'p_bitforum_edit' ) }
			<li><a class="item" href="{$smarty.const.BITFORUM_PKG_URL}edit.php">{tr}Create BitForum{/tr}</a></li>
		{/if}
	</ul>
{/strip}
