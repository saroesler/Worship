{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='javascript/jquery-ui/themes/base/jquery-ui.css'}
{pageaddvar name='javascript' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css'}

{include file='Admin/Header.tpl' __title='Worships' icon='display'}

<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='specialdayManage'}">
		<table class="z-datatable">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Title'}</th>
					<th>{gt text='Date'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<h3>{gt text="Days"}</h3>
			</br>
				{foreach from=$days item='day'}
					<tr>
						<td>{$day->getDid()}</td>
						<td>{$day->getdtitle()}</td>
						<td>{$day->getwDateFormatted()}</td>
						<td><button onclick="document.getElementById('action').value = 'del'; document.getElementById('id').value = {$day->getdid()};">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</button>
						<button onclick="document.getElementById('action').value = 'wor'; document.getElementById('id').value = {$day->getdid()};">{img src='1rightarrow_inactive.png' modname='core' set='icons/extrasmall'}</button></td>
					</tr>
				{/foreach}
				<tr> 
					<td></td>
					<td><input type="text" name="intitle" id="intitle"/></td>
					<td><input type="text" name="indate" id="indate"/></td>
					<script>
						jQuery(function() {
							jQuery( "#indate" ).datepicker();
							jQuery( "#indate" ).datepicker( "option", "dateFormat", "d'.'m'.'yy" );
							/*jQuery('#indate').datetimepicker({
							  dateFormat: 'dd.mm.yy',
							  separator: ' ',
							  minDate: new Date()
							});*/
						});
					</script>
					<td>
						<button onclick="document.getElementById('action').value = 'add'">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</button>
						<button onclick="document.getElementById('action').value = ''">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</button>
					</td>
				</tr>
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
