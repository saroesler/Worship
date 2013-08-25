{include file='Admin/Header.tpl' __title='Admin main page' icon='config'}
<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='viewmanage'}">
	<h3>{gt text="Views:"}</h3>
	<button onclick="document.getElementById('action').value = 'all';">{gt text="all worships"} {img src='kview.png' modname='core' set='icons/extrasmall'}</button>
	<button onclick="document.getElementById('action').value = 'special';">{gt text="special worships"} {img src='kview.png' modname='core' set='icons/extrasmall'}</button>
	<button onclick="document.getElementById('action').value = 'daily';">{gt text="daily worships"} {img src='kview.png' modname='core' set='icons/extrasmall'}</button>

	<input name="action" id="action" type="hidden" />
</form>
{include file='Admin/Footer.tpl'}
