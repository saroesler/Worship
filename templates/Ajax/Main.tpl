<table class="z-datatable" style="width:auto">
<colgroup>
	<col width="135">
	<col width="115">
	<col width="300">
	<col width="240">
	<col width="120">
</colgroup>
<thead>
	<tr>
		<th>{gt text='Date'}</th>
		<th>{gt text='Time'}</th>
		<th>{gt text='Title'}</th>
		<th>{gt text='Church'}</th>
		<th></th>
	</tr>
</thead>
<tbody>
	{foreach from=$Worships item='Worship'}
		<tr id="Worship{$Worship->getWid()}">
			<td><nobr>{$Worship->getWdateFormattedout()}</nobr></td>
			<td><nobr>{$Worship->getWtimeFormatted()}</nobr></td>
			<td>{$Worship->getWtitle()}</td>
			<td>{$Worship->getCname()}</td>
			<td><a href="{modurl modname=Worship type=admin func=worshipEdit id=$Worship->getWid()}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
			<a onclick="Worship_Del({$Worship->getWid()})" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>
