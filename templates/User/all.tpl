<h2>Gottesdienstordnung</h2>
<div class="z-errormsg">
	<h3>Besondere Gottesdieste</h3>
	
	{foreach from=$worshipdays item='worshipday'}
		<div class="special_mess">
		    	<p class="ueber">{$worshipday.day->getwDateFormattedout()} {$worshipday.day->getdtitle()}</p>
		    	<table style="width:auto">
					{foreach from=$worshipday.worships item='worship'}
						<tr>
							<td class="time"> {$worship.wtime->format('G:i')} Uhr:</td>
							<td>{$worship.wtitle} in {modapifunc modname='worship' type='admin' func='getChurchNameById' id=$worship.cid  }</td>
						</tr> 
		      		{/foreach}
			</table>
		</div>
	{/foreach}
</div>
<br/>
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
