<table class="z-datatable">
	<colgroup>
		<col width="">
		<col width="210">
		<col width="120">
	</colgroup>
	<thead>
		<tr>
			<th>{gt text='Title'}</th>
			<th>{gt text='Date'}</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$Days item='day'}
			<tr>
				<td>{$day->getDtitle()}</td>
				<td>{$day->getDdateFormatted()}</td>
				<td><a href="{modurl modname=Worship type=admin func=editday id=$day->getDid()}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
				<a onclick="Day_Del({$day->getDid()})" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a></td>
			</tr>
		{/foreach}
	</tbody>
</table>
