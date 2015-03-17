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
        	</thead>
        	<tbody>
        		<td>
        			<div class="z-formrow">
            			{formtextinput id="name" maxLength=300 mandatory=true text=$church->getName()}
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
