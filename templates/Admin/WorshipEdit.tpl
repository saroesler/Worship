{pageaddvar name="javascript" value="jquery-ui"}
{pageaddvar name="stylesheet" value="javascript/jquery-ui/themes/base/jquery-ui.css"}
{pageaddvar name="javascript" value="modules/Miniplan/javascript/WorshipForm.js"}
<script language="javaScript">
function id_datepicker(id)
{
	jQuery( "#"+id ).datepicker();
	jQuery( "#"+id ).datepicker( "option", "dateFormat", "dd.mm.yy");
	var value= document.getElementById('indate_org').value;
	jQuery( "#"+id ).datepicker('setDate', value);
}
jQuery(function() {
	id_datepicker("wdate");
});
</script>

{include file='Admin/Header.tpl' __title='Editor' icon='xedit'}
{form cssClass="z-form"}
    <fieldset>
        <legend>{gt text='Church Editor'}</legend>
        {formvalidationsummary}
        <table class="z-datatable">
        	<thead>
        		<th>
        			<label for="title">{gt text='Title'}</label>
        		</th>
        		<th>
        			<label for="title">{gt text='Church'}</label>
        		</th>
        		<th>
        			<label for="title">{gt text='Date'}</label>
        		</th>
        		<th>
        			<label for="title">{gt text='Time'}</label>
        		</th>
        	</thead>
        	<tbody>
        		<td>
        			<div class="z-formrow">
            			{formtextinput id="wtitle" maxLength=300 mandatory=true text=$worship->getWtitle()}
        			</div>
        		</td>
        		<td>
        			<div class="z-formrow">
            			{formdropdownlist id="cid" size="1" mandatory=true items=$cids selectedValue=$worship->getCid()}
        			</div>
        		</td>
        		<td>
        			<div class="z-formrow">
            			{formtextinput id="wdate" maxLength=300 mandatory=true text=$worship->getWdateFormatted()}
						<input type="hidden" name="indate_org" id="indate_org" value="{$worship->getWdateFormatted()}"/>
            			<script type="text/javascript">
						jQuery(function() {
							jQuery( "#wdate" ).datepicker();
							jQuery( "#wdate" ).datepicker( "option", "dateFormat", "dd'.'mm'.'yy" );
						});
						</script>
        			</div>
        		</td>
        		<td>
        			<div class="z-formrow">
            			{formtextinput id="wtime" maxLength=300 mandatory=true text=$worship->getWtimeFormatted()}
        			</div>
        		</td>
        	</tbody>
        </table>
       
	   <div class="z-formbuttons z-buttons">
		   {formbutton class="z-bt-ok" commandName="save" __text="Save"}
		   {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
	   </div>
    </fieldset>
{/form}

{include file='Admin/Footer.tpl'}
