function Worship_Del(id)
{
	var params = new Object();
	params['id'] = id;
	if(confirm("Soll der Gottesdienst wirklich gelöscht werden?"))
	{
		new Zikula.Ajax.Request(
			"ajax.php?module=Worship&func=Worships_Del",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					if(returns['id'])
					{
						document.getElementById('Worship'+returns['id']).style.display = "none";
					}
				}
			}
		);
	}
}

function Worship_Save()
{
	var params = new Object();
	params['title'] = document.getElementById('intitle').value;
	params['date'] = document.getElementById('indate').value;
	params['time'] = document.getElementById('intime').value;
	params['church'] = document.getElementById('inchurch').value;
	new Zikula.Ajax.Request(
		"ajax.php?module=Worship&func=Worships_save",
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
					Worship_Clear();
				}
			}
		}
	);
}

function Worship_Clear()
{
	document.getElementById('intitle').value = "";
	document.getElementById('indate').value = "";
	document.getElementById('intime').value = "";
}

