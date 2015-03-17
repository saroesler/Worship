{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='javascript/jquery-ui/themes/base/jquery-ui.css'}
{pageaddvar name='javascript' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css'}

{include file='Admin/Header.tpl' __title='Special Days' icon='display'}
{pageaddvar name="javascript" value="modules/Worship/javascript/Days.js"}

<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='addday'}">
	<div id="List">
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
					<tr id="Day{$day->getDid()}">
						<td>{$day->getDtitle()}</td>
						<td>{$day->getDdateFormatted()}</td>
						<td><a href="{modurl modname=Worship type=admin func=editday id=$day->getDid()}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
						<a onclick="Day_Del({$day->getDid()})" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a></td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
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
				<tr> 
					<td><input type="text" name="intitle" id="intitle"/></td>
					<td><input type="text" name="indate" id="indate"/></td>
					<script>
						jQuery(function() {
							jQuery( "#indate" ).datepicker();
							jQuery( "#indate" ).datepicker( "option", "dateFormat", "dd'.'mm'." );
							/*jQuery('#indate').datetimepicker({
							  dateFormat: 'dd.mm.yy',
							  separator: ' ',
							  minDate: new Date()
							});*/
						});
					</script>
					<td>
						<a onclick="Day_Save()"  class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</a>
						<a onclick="Day_Clear()"  class="z-button">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</a>
					</td>
				</tr>
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
