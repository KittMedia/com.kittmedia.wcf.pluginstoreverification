{include file='documentHeader'}
<head>
	<title>{lang}wcf.header.menu.woltlabPluginStoreVerification{/lang} - {PAGE_TITLE|language}</title>
	
	{include file='headInclude'}
	<script data-relocate="true">
		//<![CDATA[
		$(function() {
			new WCF.Message.FormGuard();
		});
		//]]>
	</script>
</head>

<body id="tpl{$templateName|ucfirst}">
{include file='header'}

<header class="boxHeadline">
	<h1>{lang}wcf.header.menu.woltlabPluginStoreVerification{/lang}</h1>
</header>

{include file='userNotice'}

{include file='formError'}

<form id="messageContainer" class="jsFormGuard" method="post" action="{link controller='WoltlabPluginStoreVerification'}{/link}">
	<div class="container containerPadding marginTop">
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			<dl{if $errorField == 'apiKey'} class="formError"{/if}>
				<dt><label for="apiKey">{lang}wcf.woltlab.pluginstoreverification.apiKey{/lang}</label></dt>
				<dd>
					<input type="text" id="apiKey" name="apiKey" value="{$apiKey}" required="required" maxlength="255" class="medium" />
					{if $errorField == 'apiKey'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.woltlab.pluginstoreverification.apiKey.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
					<small>{lang}wcf.woltlab.pluginstoreverification.apiKey.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'woltlabID'} class="formError"{/if}>
				<dt><label for="woltlabID">{lang}wcf.woltlab.pluginstoreverification.woltlabID{/lang}</label></dt>
				<dd>
					<input type="text" id="woltlabID" name="woltlabID" value="{$woltlabID}" required="required" maxlength="255" class="medium" />
					{if $errorField == 'woltlabID'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.woltlab.pluginstoreverification.woltlabID.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
					<small>{lang}wcf.woltlab.pluginstoreverification.woltlabID.description{/lang}</small>
				</dd>
			</dl>
			
			<dl{if $errorField == 'content'} class="formError"{/if}>
				<dt><label for="content">{lang}wcf.woltlab.pluginstoreverification.content{/lang}</label></dt>
				<dd>
					{htmloptions options=$availableContentTree name='content' selected=$content}
				</dd>
			</dl>
			
			{event name='dataFields'}
		</fieldset>
		
		{event name='fieldsets'}
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}

</body>
</html>