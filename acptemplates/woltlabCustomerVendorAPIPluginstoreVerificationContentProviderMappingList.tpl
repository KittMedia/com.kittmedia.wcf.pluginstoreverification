{include file='header' pageTitle='wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{$pageTitle|language}</h1>
	</div>
	
	{hascontent}
		<nav class="contentHeaderNavigation">
			<ul>
				{content}{event name='contentHeaderNavigation'}{/content}
			</ul>
		</nav>
	{/hascontent}
</header>

{hascontent}
	<div class="paginationTop">
		{content}{pages print=true assign=pagesLinks controller='WoltlabCustomerVendorAPIPluginstoreVerificationContentProviderMappingList' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}{/content}
	</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnFileID{if $sortField == 'fileID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='WoltlabVendorAPIPluginstoreFileList'}pageNo={@$pageNo}&sortField=fileID&sortOrder={if $sortField == 'fileID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnFileName">{lang}wcf.woltlabapi.pluginstore.file.name{/lang}</th>
					<th class="columnTitle columnContentProviderName">{lang}wcf.woltlabapi.pluginstore.file.contentProvider{/lang}</th>
					<th class="columnTitle columnContentProviderObjectName">{lang}wcf.woltlabapi.pluginstore.file.contentProvider.objectID{/lang}</th>
					
					{event name='columnHeads'}
				</tr>
			</thead>
			
			<tbody>
				{foreach from=$objects item=pluginstoreFile}
					<tr id="pluginstoreFile{@$pluginstoreFile->getObjectID()}">
						<td class="columnIcon">
							<a href="{link controller='WoltlabCustomerVendorAPIPluginstoreContentProviderFileEdit' id=$pluginstoreFile->getObjectID()}{/link}" class="jsTooltip" title="{lang}wcf.global.button.edit{/lang}">
								<span class="icon icon16 fa-pencil"></span>
							</a>
							
							{event name='rowButtons'}
						</td>
						<td class="columnID columnFileID">{@$pluginstoreFile->getObjectID()}</td>
						<td class="columnText columnFileName">{$pluginstoreFile->name|language}</td>
						<td class="columnTitle columnContentProviderName">{@$pluginstoreFile->getContentProviderName()}</td>
						<td class="columnTitle columnContentProviderObjectName">{@$pluginstoreFile->getContentProviderObjectName()}</td>
						
						{event name='columns'}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
	
	<footer class="contentFooter">
		{hascontent}
			<div class="paginationBottom">
				{content}{@$pagesLinks}{/content}
			</div>
		{/hascontent}
		
		{hascontent}
			<nav class="contentFooterNavigation">
				<ul>
					{content}{event name='contentFooterNavigation'}{/content}
				</ul>
			</nav>
		{/hascontent}
	</footer>
{else}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/if}

{include file='footer'}
