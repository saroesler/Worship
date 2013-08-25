{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='javascript/jquery-ui/themes/base/jquery-ui.css'}
{pageaddvar name='javascript' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css'}

{include file='Admin/Header.tpl' __title='Worships' icon='display'}

<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='dailyworshipManage'}">
		<table class="z-datatable" style="width:auto">
			<thead>
				<tr>
					<th>{gt text='ID'}</th>
					<th>{gt text='Title'}</th>
					<th>{gt text='Church'}</th>
					<th>{gt text='Weekday'}</th>
					<th>{gt text='Time'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$worships item='worship'}
					<tr>
						<td>{$worship->getcwid()}</td>
						<td>{$worship->getnwtitle()}</td>
						<td>{$worship->getCname()}</td>
						<td>{$worship->getDayName()}</td>
						<td>{$worship->getnwtimeFormatted()}</td>
						<td><button onclick="document.getElementById('action').value = 'del'; document.getElementById('id').value = {$worship->getcwid()};">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</button></td>
					</tr>
				{/foreach}
				<tr> 
					<td></td>
					<td><input type="text" name="intitle" id="intitle"/></td>
					<td>{modapifunc modname='Worship' type='Admin' func='getChurchSelector' name='inchurch'}{*<input type="text" name="inchurch" />*}</td>
					<td>{modapifunc modname='Worship' type='Admin' func='getWeekdaySelector' name='inday'}{*<input type="text" name="inday" />*}</td>
					<td><input type="text" name="intime" id="intime"/></td>
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
