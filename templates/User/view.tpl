<style>
#Gottesdiensttabele th, #Gottesdiensttabele td{
}

table { display: block; table-layout:fixed; }

td, th{
		vertical-align:top;
		padding:10px;
		min-width:150px;
}

tr{
	border-top:1px #fff;
}
.Gottesdienst_Gottesdienstdatum{
	text-align:left;
	padding-right:10px;
	width:120px;
	font-weight:bold;
}

.banner_img{
	width: 897px;
}
</style>

{checkpermission component="Worship::" instance="::" level=ACCESS_ADMIN assign=admin}
	{if $admin}
		<a href="{modurl modname='Worship' type='admin' func='main'}" >{img src='configure.png' modname='core' set='icons/extrasmall'}{gt text='Admin page'}</a>
	{/if}
<h1>Gottesdienstordnung</h1>
{img src='Bildleiste_Userview.png' class='banner_img' }{*border='1'*}

<br />
<br />
<br />

	<table id="Gottesdiensttabele" class="tabelle_light" style="margin-left:0px;">
		<thead>
			<tr border="0" style="border:0px;">
				<th class="Gottesdienst_Gottesdienstdatum"></th>
				{foreach from=$churches item='church'}
					<th style="text-align:left">{$church->getName()}</th>
				{/foreach}
			</tr>
		</thead>
		<tbody>
			{foreach from=$dates item='date'}
				<tr>
					<td class="Gottesdienst_Gottesdienstdatum"><nobr>{$date.date}</nobr><br/> 
						{if ($date.dayname!='')}
							<span style="font-weight:bold">{$date.dayname}</span>
						{/if}
					</td>
					{foreach from=$churches item='church'}
						<td style="padding-left:10px;">
							{foreach from=$Worships item='Worship'}
								{if ($Worship->getWdateFormattedout()==$date.date)&&($Worship->getCid()==$church->getCid())}
									{$Worship->getWtimeFormatted()}&nbsp;&nbsp;<span style="padding-left: 5px;">{$Worship->getWtitle()}</span> </br>
								{/if}
							{/foreach}
						</td>
					{/foreach}
				</tr>
			{/foreach}
		</tbody>
	</table>

