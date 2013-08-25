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
{checkpermission component="Worship::" instance=".*" level="ACCESS_ADMIN" assign=displayeditlink}
{if $displayeditlink}
<a href="{modurl modname='Worship' type='admin' func='main'}">{gt text='Edit'}</a>
{/if}
