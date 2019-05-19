{include file='header' pageTitle='wcf.woltlabapi.pluginstore.file.contentProvider.mapping.edit'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{$pageTitle|language}</h1>
	</div>
	
	<nav class="contentHeaderNavigation">
		<ul>
			<li><a href="{link controller='WoltlabCustomerVendorAPIPluginstoreVerificationContentProviderMappingList'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList{/lang}</span></a></li>
			
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{@$action}{/lang}</p>
{/if}

<form method="post" action="{link controller='WoltlabCustomerVendorAPIPluginstoreContentProviderFileEdit' id=$fileID}{/link}">
	<div class="section">
		<h2 class="sectionTitle">{lang}wcf.global.form.data{/lang}</h2>
		
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
		
		{event name='informationFields'}
	</div>
	
	{event name='afterSections'}
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{hascontent}
	<footer class="contentFooter">
		<nav class="contentFooterNavigation">
			<ul>
				{content}{event name='contentFooterNavigation'}{/content}
			</ul>
		</nav>
	</footer>
{/hascontent}

{include file='footer'}

<script data-relocate="true">
	require(['Core'], function(Core) {
		var contentProviderIDSelect = elBySel('select[name="contentProviderID"]');
		contentProviderIDSelect.addEventListener('change', function(event) {
			var selectedOption = parseInt(event.currentTarget.options[event.currentTarget.selectedIndex].value);
			var contentProviderOption = elById('contentProviderOption' + selectedOption);
			
			elBySelAll('.contentProviderOptionSelect', undefined, function(contentProviderSelect) {
				elHide(contentProviderSelect);
			});
			
			if (selectedOption !== 0) {
				elShow(contentProviderOption);
			}
		});
		
		Core.triggerEvent(contentProviderIDSelect, 'change');
		
		{event name='javascriptInit'}
	});
</script>
