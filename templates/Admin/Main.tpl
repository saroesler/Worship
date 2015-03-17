{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='javascript/jquery-ui/themes/base/jquery-ui.css'}
{pageaddvar name='javascript' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css'}

{include file='Admin/Header.tpl' __title='Worships' icon='display'}
{pageaddvar name="javascript" value="modules/Worship/javascript/Worship.js"}

<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='worshipadd'}">
	<div id="List">
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
		</div>
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
				<tr> 
					<td><input type="text" name="indate" id="indate" maxlength="10" size="10"/></td>
					<script>
						jQuery(function() {
							jQuery( "#indate" ).datepicker();
							jQuery( "#indate" ).datepicker( "option", "dateFormat", "dd'.'mm'.'yy" );
							/*jQuery('#indate').datetimepicker({
							  dateFormat: 'dd.mm.yy',
							  separator: ' ',
							  minDate: new Date()
							});*/
						});
					</script>
					<td><input type="text" name="intime" id="intime" maxlength="5" size="5"/></td>
					<td><input type="text" name="intitle" id="intitle"/></td>
					<td>{modapifunc modname='Worship' type='Admin' func='getChurchSelector' name='inchurch'}</td>
					<td>
						<a onclick="Worship_Save()"  class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</a>
						<a onclick="Worship_Clear()" class="z-button">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</a>
					</td>
				</tr>
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

<br/>
<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='generate'}">
	<table>
		<td>
			<a href="{modurl modname=Worship type=admin func=worshipDel all='jes'}" class="z-button">{gt text= "Delete all Worships"}{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
		</td>
		<td>{gt text="from"}: <input type="text" name="fromdate" id="fromdate" maxlength="8" style="width:100px"/></td>
			<script>
				jQuery(function() {
					jQuery( "#fromdate" ).datepicker();
					jQuery( "#fromdate" ).datepicker( "option", "dateFormat", "dd'.'mm'.'yy'" );
				});
			</script>
		<td>{gt text="to"}: <input type="text" name="todate" id="todate" maxlength="8" style="width:100px"/></td>
			<script>
				jQuery(function() {
					jQuery( "#todate" ).datepicker();
					jQuery( "#todate" ).datepicker( "option", "dateFormat", "dd'.'mm'.'yy'" );
				});
			</script>
		</td>
		<td>
			<button onclick="document.getElementById('option').value='add'" class="z-button">{gt text= "Generate Worships"}{img src='button_ok.png' modname='core' set='icons/extrasmall'}</button>
		</td>
		<td>
			<button onclick="document.getElementById('option').value='del'" class="z-button">{gt text= "Delete Worships"}{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</button>
		</td>
	</table>
	<input id="option" type="hidden" name="option">
</form>
{include file='Admin/Footer.tpl'}
