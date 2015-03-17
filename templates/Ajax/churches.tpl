{foreach from=$churches item='church'}
	<tr id="Churches{$church->getCid()}">
		<td>{$church->getCid()}</td>
		<td>{$church->getName()}</td>
		<td>
		<a href="{modurl modname=Worship type=admin func=ChurchEdit id=$church->getCid()}" class="z-button">{img src='xedit.png' modname='core' set='icons/extrasmall'}</a>
		<a onclick="Churches_Del({$church->getCid()})" class="z-button">{img src='14_layer_deletelayer.png' modname='core' set='icons/extrasmall'}</a>
		</td>
	</tr>
{/foreach}
<tr> 
	<td></td>
	<td><input type="text" name="inname" id="inname"/></td>
	<td>
		<a onclick="Churches_Save()" class="z-button">{img src='button_ok.png' modname='core' set='icons/extrasmall'}</a>
		<a onclick="Churches_Clear()" class="z-button">{img src='button_cancel.png' modname='core' set='icons/extrasmall'}</a>
	</td>
</tr>
