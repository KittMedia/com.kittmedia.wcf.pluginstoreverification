{include file='header' pageTitle='wcf.woltlabapi.pluginstore.file.contentProvider.mapping.edit'}

<header class="boxHeadline">
	<h1>{lang}wcf.woltlabapi.pluginstore.file.contentProvider.mapping.edit{/lang}</h1>
</header>

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{@$action}{/lang}</p>
{/if}

<div class="contentNavigation">
	<nav>
		<ul>
			<li><a href="{link controller='WoltlabCustomerVendorAPIPluginstoreVerificationContentProviderMappingList'}{/link}" class="button"><span class="icon icon16 icon-list"></span> <span>{lang}wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList{/lang}</span></a></li>
			
			{event name='contentNavigationButtons'}
		</ul>
	</nav>
</div>

<form method="post" action="{link controller='WoltlabCustomerVendorAPIPluginstoreContentProviderFileEdit' id=$fileID}{/link}">
	<div class="container containerPadding marginTop">
		{event name='beforeFieldsets'}
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl>
				<dt><label for="name">{lang}wcf.woltlabapi.pluginstore.file.name{/lang}</label></dt>
				<dd>
					<input type="text" id="name" name="name" readonly="readonly" value="{$file->name|language}" class="long" />
				</dd>
			</dl>
			
			<dl{if $errorField == 'contentProviderID'} class="formError"{/if}>
				<dt><label for="contentProviderID">{lang}wcf.woltlabapi.pluginstore.file.contentProvider{/lang}</label></dt>
				<dd>
					{htmlOptions name="contentProviderID" options=$availableContentProvider selected=$contentProviderID}
					{if $errorField == 'contentProviderID'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.{$errorType}{/lang}
							{else}
								{lang}wcf.woltlabapi.pluginstore.file.contentProvider.error.{$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			{foreach from=$availableContentProvider key=contentProviderObjectTypeID item=contentProvider}
				{if !$contentProviderObjectTypeID|empty}
					<dl id="contentProviderOption{$contentProviderObjectTypeID}" class="contentProviderOptionSelect{if $errorField == 'contentProviderOption'|concat:$contentProviderObjectTypeID} formError{/if}">
						<dt><label>{lang}wcf.woltlabapi.pluginstore.file.contentProvider.objectID{/lang}</label></dt>
						<dd>
							{htmlOptions name="contentProviderOption["|concat:$contentProviderObjectTypeID|concat:"]" options=$contentProvider->getSelectOptions() selected=$contentProviderOptionID}
							{if $errorField == 'contentProviderOption'|concat:$contentProviderObjectTypeID}
								<small class="innerError">
									{if $errorType == 'empty'}
										{lang}wcf.global.form.error.{$errorType}{/lang}
									{else}
										{lang}wcf.woltlabapi.pluginstore.file.contentProvider.objectID.error.{$errorType}{/lang}
									{/if}
								</small>
							{/if}
						</dd>
					</dl>
					
					{event name='contentProviderOptionFields'}
				{/if}
			{/foreach}
			
			{event name='dataFields'}
			
			<script data-relocate="true">
				//<![CDATA[
				$(function() {
					$('select[name="contentProviderID"]').on('change', function(event) {
						var $target = $(event.currentTarget);
						var $contentProviderOption = $('#contentProviderOption' + $target.val());
						
						$('.contentProviderOptionSelect:not(' + '#contentProviderOption' + $target.val() + ')').hide();
						$contentProviderOption.show();
					}).trigger('change');
					
					{event name='javascriptInit'}
				});
				//]]>
			</script>
			
		</fieldset>
		
		{event name='afterFieldsets'}
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}