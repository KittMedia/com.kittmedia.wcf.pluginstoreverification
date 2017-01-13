{include file='header' pageTitle='wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList'}

<header class="boxHeadline">
	<h1>{lang}wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList{/lang}</h1>
</header>

<div class="contentNavigation">
	{pages print=true assign=pagesLinks controller='WoltlabCustomerVendorAPIPluginstoreVerificationContentProviderMappingList' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	<nav>
		<ul>
			{event name='contentNavigationButtonsTop'}
		</ul>
	</nav>
</div>

{hascontent}
	<div class="tabularBox tabularBoxTitle marginTop">
		<header>
			<h2>{lang}wcf.acp.menu.link.content.woltlabVendorAPI.pluginstoreVerificationContentProviderMappingList{/lang} <span class="badge badgeInverse">{#$items}</span></h2>
		</header>
		
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
				{content}
					{foreach from=$objects item=pluginstoreFile}
						<tr id="pluginstoreFile{@$pluginstoreFile->getObjectID()}">
							<td class="columnIcon">
								<a href="{link controller='WoltlabVendorAPIPluginstoreContentProviderFileEdit' id=$pluginstoreFile->getObjectID()}{/link}" class="jsTooltip" title="{lang}wcf.global.button.edit{/lang}">
									<span class="icon icon16 icon-pencil"></span>
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
				{/content}
			</tbody>
		</table>
	</div>
	
	<div class="contentNavigation">
		{@$pagesLinks}
		
		<nav>
			<ul>
				{event name='contentNavigationButtonsBottom'}
			</ul>
		</nav>
	</div>
{hascontentelse}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/hascontent}

{include file='footer'}