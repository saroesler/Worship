{pageaddvar name='javascript' value='jquery-ui'}
{pageaddvar name='stylesheet' value='javascript/jquery-ui/themes/base/jquery-ui.css'}
{pageaddvar name='javascript' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js'}
{pageaddvar name='stylesheet' value='javascript/jquery-plugins/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css'}

{include file='Admin/Header.tpl' __title='General Worships' icon='display'}
{pageaddvar name="javascript" value="modules/Worship/javascript/GeneralWorships.js"}

<form class="z-form" method="post" action="{modurl modname='Worship' type='Admin' func='addgeneralworships'}">
		<table class="z-datatable" style="width:auto">
			<thead>
				<tr>
					<th>{gt text='Weekday'}</th>
					<th>{gt text='Time'}</th>
					<th>{gt text='Title'}</th>
					<th>{gt text='Church'}</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="List">
				{foreach from=$GeneralWorships item='GeneralWorship'}
					{if $GeneralWorship->getActive()}
					<tr id="GeneralWorship{$GeneralWorship->getGwid()}">
					{else}
					<tr style="background: linear-gradient(#FAFAFA, #DFDFDF) repeat scroll 0 0 rgba(0, 0, 0, 0);" id="GeneralWorship{$GeneralWorship->getGwid()}">
					{/if}
						<td>{$GeneralWorship->getDayName()}</td>
						<td>{$GeneralWorship->getGwtimeFormatted()}</td>
						<td>{$GeneralWorship->getGwtitle()}</td>
						<td>{$GeneralWorship->getCname()}</td>
						<td><a href="{modurl modname=Worship type=admin func=GeneralworshipEdit id=$GeneralWorship->getGwid()}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
						<a onclick="GeneralWorships_Del({$GeneralWorship->getGwid()})" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
						{if $GeneralWorship->getActive()}
							<a id="GeneralWorshipLinkred{$GeneralWorship->getGwid()}" onclick="GeneralWorships_State({$GeneralWorship->getGwid()},0)" class="z-button">{img src='redled.png' modname='core' set='icons/extrasmall'}</a>
							<a id="GeneralWorshipLinkgreen{$GeneralWorship->getGwid()}" onclick="GeneralWorships_State({$GeneralWorship->getGwid()},1)" class="z-button" style="display:none">{img src='greenled.png' modname='core' set='icons/extrasmall'}</a>
						{else}
							<a id="GeneralWorshipLinkred{$GeneralWorship->getGwid()}" onclick="GeneralWorships_State({$GeneralWorship->getGwid()},0)" class="z-button" style="display:none">{img src='redled.png' modname='core' set='icons/extrasmall'}</a>
							<a id="GeneralWorshipLinkgreen{$GeneralWorship->getGwid()}" onclick="GeneralWorships_State({$GeneralWorship->getGwid()},1)" class="z-button">{img src='greenled.png' modname='core' set='icons/extrasmall'}</a>
						{/if}
						</td>
					</tr>
				{/foreach}
				<tr> 
					<td>{modapifunc modname='Worship' type='Admin' func='getWeekdaySelector' name='inday' id='inday'}</td>
					<td><input type="text" name="intime" id="intime" maxlength="5" size="5"/></td>
					<td><input type="text" name="intitle" id="intitle"/></td>
					<td>{modapifunc modname='Worship' type='Admin' func='getChurchSelector' name='inchurch'}</td>
					<td>
						<a onclick="GeneralWorships_Save()" class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</a>
						<a onclick="GeneralWorships_Clear()" class="z-button">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</a>
					</td>
				</tr>
			</tbody>
		</table>
	<input name="action" id="action" type="hidden" />
	<input name="id" id="id" type="hidden" />
</form>

{include file='Admin/Footer.tpl'}
