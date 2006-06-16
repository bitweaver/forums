{* $Header: /cvsroot/bitweaver/_bit_forums/templates/edit_bitforum_topic.tpl,v 1.1 2006/06/16 07:18:03 spiderr Exp $ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin bitforum">
	{if $preview}
		<h2>Preview {$gContent->getTitle()|escape}</h2>
		<div class="preview">
			{include file="bitpackage:bitforum/bitforum_display.tpl" page=`$gContent->mInfo.bitforum_id`}
		</div>
	{/if}

	<div class="header">
		<h1>
			{if $gContent->isValid()}
				{tr}{tr}Edit{/tr} {$gContent->getTitle()|escape}{/tr}
			{else}
				{tr}Create New Topic{/tr}
			{/if}
		</h1>
	</div>

	<div class="body">
		{form enctype="multipart/form-data" id="editbitforumform"}
					{legend legend="Edit/Create BitForum Record"}
						<input type="hidden" name="bitforum[forum_id]" value="{$gForum->getField('bitforum_id')}" />

						<div class="row">
							{formlabel label="Topic Title" for="title"}
							{forminput}
								<input type="text" size="60" maxlength="200" name="bitforum[title]" id="title" value="{$gContent->getTitle()|escape}" />
							{/forminput}
						</div>

						<div class="row">
							{formlabel label="Forum" for="description"}
							{forminput}
								{$gForum->getTitle()}
							{/forminput}
						</div>

						{include file="bitpackage:liberty/edit_format.tpl"}

						{if $gBitSystem->isFeatureActive('package_smileys')}
							{include file="bitpackage:smileys/smileys_full.tpl"}
						{/if}

						{if $gBitSystem->isFeatureActive('package_quicktags')}
							{include file="bitpackage:quicktags/quicktags_full.tpl"}
						{/if}

						<div class="row">
							{forminput}
								<textarea {spellchecker} id="{$textarea_id}" name="bitforum[edit]" rows="{$smarty.cookies.rows|default:20}" cols="50">{$gContent->mInfo.data|escape:html}</textarea>
							{/forminput}
						</div>

						{* any simple service edit options *}
						{include file="bitpackage:liberty/edit_services_inc.tpl serviceFile=content_edit_mini_tpl}

						<div class="row submit">
							<input type="submit" name="preview" value="{tr}Preview{/tr}" /> 
							<input type="submit" name="save_topic" value="{tr}Save{/tr}" />
						</div>
					{/legend}

				{* any service edit template tabs *}
				{include file="bitpackage:liberty/edit_services_inc.tpl serviceFile=content_edit_tab_tpl}
		{/form}
	</div><!-- end .body -->
</div><!-- end .bitforum -->

{/strip}
