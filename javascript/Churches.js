function Churches_Del(id)
{
	var params = new Object();
	params['id'] = id;
	if(confirm("Soll die Kirche wirklich gelöscht werden?"))
	{
		new Zikula.Ajax.Request(
			"ajax.php?module=Worship&func=Churches_Del",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					
					if(returns['id'])
					{
						document.getElementById('Churches'+returns['id']).style.display = "none";
					}
				}
			}
		);
	}
}

function Churches_Save()
{
	var params = new Object();
	params['name'] = document.getElementById('inname').value;
	new Zikula.Ajax.Request(
		"ajax.php?module=Worship&func=Churches_save",
		{
			parameters: params,
			onComplete:	function (ajax) 
			{
				var returns = ajax.getData();
				if(returns['text']!="")
					alert(returns['text']);
				if(returns['ok']==1)
				{
					document.getElementById('List').innerHTML = returns['list'];
					document.getElementById('inname').value = "";
				}
			}
		}
	);
}

function Churches_Clear()
{
	document.getElementById('inname').value = "";
}

