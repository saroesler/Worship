<style>
	table { width:100%; table-layout:fixed; border:1px solid #000;}
	
	td, th{
			vertical-align:top;
			padding:10px;
			border:1px solid #000;
	}

	.Gottesdienst_Gottesdienstdatum{
		text-align:left;
		padding-right:20px;
		width:120px;
	}
	
	p, a, td, li, th {
		font-family: Arial,Helvetica,Geneva,Sans-serif;
		font-size: 14px;
		padding:10px;
	}
</style>

{$heading}
<br/><br/>

<table id="Gottesdiensttabele" cellspacing="0" cellpadding="1" border="1">
	<tr>
		<td class="Gottesdienst_Gottesdienstdatum"></td>
		{foreach from=$churches item='church'}
			<th style="text-align:left"><h4>{$church->getName()}</h4></th>
		{/foreach}
	</tr>
	{foreach from=$dates item='date'}
		<tr>
			<th class="Gottesdienst_Gottesdienstdatum"><h4><nobr>{$date.date}</nobr><br/> <span style="font-weight:normal">{$date.dayname}</span></h4></th>
			{foreach from=$churches item='church'}
				<td style="padding-left:10px;">
					{foreach from=$Worships item='Worship'}
						{if ($Worship->getWdateFormattedout()==$date.date)&&($Worship->getCid()==$church->getCid())}
							{$Worship->getWtimeFormatted()}&nbsp;&nbsp;<span style="padding-left: 5px;">{$Worship->getWtitle()}</span> <br/>
						{/if}
					{/foreach}
				</td>
			{/foreach}
		</tr>
	{/foreach}
</table>
