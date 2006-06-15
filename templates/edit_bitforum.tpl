{* $Header: /cvsroot/bitweaver/_bit_forums/templates/edit_bitforum.tpl,v 1.1 2006/06/15 22:27:17 spiderr Exp $ *}
{strip}
<div class="floaticon">{bithelp}</div>

<div class="admin bitforum">
	{if $preview}
		<h2>Preview {$gContent->mInfo.title|escape}</h2>
		<div class="preview">
			{include file="bitpackage:bitforum/bitforum_display.tpl" page=`$gContent->mInfo.bitforum_id`}
		</div>
	{/if}

	<div class="header">
		<h1>
			{if $gContent->mInfo.bitforum_id}
				{tr}{tr}Edit{/tr} {$gContent->mInfo.title|escape}{/tr}
			{else}
				{tr}Create New Record{/tr}
			{/if}
		</h1>
	</div>

	<div class="body">
		{form enctype="multipart/form-data" id="editbitforumform"}
			{jstabs}
				{jstab}
					{legend legend="Edit/Create BitForum Record"}
						<input type="hidden" name="bitforum[bitforum_id]" value="{$gContent->mInfo.bitforum_id}" />

						<div class="row">
							{formlabel label="Title" for="title"}
							{forminput}
								<input type="text" size="60" maxlength="200" name="bitforum[title]" id="title" value="{$gContent->mInfo.title|escape}" />
							{/forminput}
						</div>

						<div class="row">
							{formlabel label="Description" for="description"}
							{forminput}
								<input size="60" type="text" name="bitforum[description]" id="description" value="{$gContent->mInfo.description|escape}" />
								{formhelp note="Brief description of the page."}
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
							<input type="submit" name="save_bitforum" value="{tr}Save{/tr}" />
						</div>
					{/legend}
				{/jstab}

				{* any service edit template tabs *}
				{include file="bitpackage:liberty/edit_services_inc.tpl serviceFile=content_edit_tab_tpl}
			{/jstabs}
		{/form}
	</div><!-- end .body -->
</div><!-- end .bitforum -->

{/strip}
