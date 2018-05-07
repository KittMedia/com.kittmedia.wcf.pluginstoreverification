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

{if $success|isset}
	<p class="success">{lang}wcf.woltlabapi.pluginstore.contentProvider.success{/lang}</p>
{/if}

<form id="messageContainer" class="jsFormGuard" method="post" action="{link controller='WoltlabPluginStoreVerification'}{/link}">
	<div class="container containerPadding marginTop">
		{event name='beforeFieldsets'}
		
		<fieldset>
			<legend>{lang}wcf.global.form.data{/lang}</legend>
			
			{include file='woltlabVendorCustomerAPIInputFields'}
			
			<dl{if $errorField == 'pluginstoreFileID'} class="formError"{/if}>
				<dt><label for="pluginstoreFileID">{lang}wcf.woltlabapi.pluginstore.file.productName{/lang}</label></dt>
				<dd>
					{htmlOptions options=$availableFiles name='pluginstoreFileID' selected=$fileID}
					{if $errorField == 'pluginstoreFileID'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.{$errorType}{/lang}
							{else}
								{lang}wcf.woltlabapi.pluginstore.file.productName.name.error.{$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'privacyAccept'} class="formError"{/if}>
				<dt></dt>
				<dd>
					<label><input type="checkbox" id="privacyAccept" name="privacyAccept" value="1" required /> {lang}wcf.woltlabapi.pluginstore.privacyInformation{/lang}</label>
					{if $errorField == 'privacyAccept'}
						<small class="innerError">
							{lang}wcf.woltlabapi.pluginstore.privacyInformation.error.{@$errorType}{/lang}
						</small>
					{/if}
				</dd>
			</dl>
			
			{event name='dataFields'}
		</fieldset>
		
		{event name='afterFieldsets'}
	</div>
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		var $button = $('.formSubmit > input[type="submit"]').disable();
		
	$('#privacyAccept').on('change', function(event) {
			if ($(this).is(':checked')) {
				$button.enable();
			}
			else {
				$button.disable();
			}
		});
	});
	//]]>
</script>

{include file='footer'}

</body>
</html>