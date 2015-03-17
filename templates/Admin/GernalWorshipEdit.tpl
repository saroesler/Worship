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
        			<label for="title">{gt text='Weekday'}</label>
        		</th>
        		<th>
        			<label for="title">{gt text='Time'}</label>
        		</th>
        	</thead>
        	<tbody>
        		<td>
        			<div class="z-formrow">
            			{formtextinput id="gwtitle" maxLength=300 mandatory=true text=$generalworship->getGwtitle()}
        			</div>
        		</td>
        		<td>
        			<div class="z-formrow">
            			{formdropdownlist id="cid" size="1" mandatory=true items=$cids selectedValue=$generalworship->getCid()}
        			</div>
        		</td>
        		<td>
        			<div class="z-formrow">
            			{formdropdownlist id="weekday" size="1" mandatory=true items=$weekdaylist selectedValue=$generalworship->getWeekday()}
        			</div>
        		</td>
        		<td>
        			<div class="z-formrow">
            			{formtextinput id="gwtime" maxLength=300 mandatory=true text=$generalworship->getGwtimeFormatted()}
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
