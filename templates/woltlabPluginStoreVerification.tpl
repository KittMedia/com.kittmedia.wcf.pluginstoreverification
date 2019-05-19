{include file='header'}

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.woltlabapi.pluginstore.contentProvider.success{/lang}</p>
{/if}

<form id="messageContainer" class="jsFormGuard" method="post" action="{link controller='WoltlabPluginStoreVerification'}{/link}">
	{event name='beforeSections'}
	
	<div class="section">
		<h2 class="sectionTitle">{lang}wcf.global.form.data{/lang}</h2>
		
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
	</div>
	
	{event name='afterSections'}
	
	<div class="formSubmit">
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}

<script data-relocate="true">
	require(['Core'], function(Core) {
		new WCF.Message.FormGuard();
		
		var privacyAccept = elById('privacyAccept');
		var submitButton = elBySel('.formSubmit > input[type="submit"]');
		
		privacyAccept.addEventListener(WCF_CLICK_EVENT, function(event) {
			if (!event.currentTarget.checked && !submitButton.hasAttribute('disabled')) {
				elAttr(submitButton, 'disabled', 'disabled');
			}
			else {
				submitButton.removeAttribute('disabled');
			}
		});
		
		Core.triggerEvent(privacyAccept, WCF_CLICK_EVENT);
	});
</script>
