<h2>Gottesdienstordnung</h2>
{foreach from=$worshipchurches item='worshipchurch'}
	<h4>{$worshipchurch.church->getName()}</h4>
	<h5><ul>{$worshipchurch.church->getAdress()}</ul></h5>
	<table style="width:auto">
	{foreach from=$worshipchurch.worships item='worship'}
	<tr>
		<td>{modapifunc modname='worship' type='admin' func='getDayNameById' id=$worship.weektime short=true}</td>
		<td class="time">{$worship.nwtime->format('G:i')} Uhr:</td>
		<td>{$worship.nwtitle}</td>
	</tr>
	{/foreach}
	</table>
	<br/><br/>
	
{/foreach}
{checkpermission component="Worship::" instance=".*" level="ACCESS_ADMIN" assign=displayeditlink}
{if $displayeditlink}
<a href="{modurl modname='Worship' type='admin' func='main'}">{gt text='Edit'}</a>
{/if}
