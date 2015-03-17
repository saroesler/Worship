function Day_Del(id)
{
	var params = new Object();
	params['id'] = id;
	if(confirm("Soll der Tag wirklich gelöscht werden?"))
	{
		new Zikula.Ajax.Request(
			"ajax.php?module=Worship&func=Days_Del",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					if(returns['id'])
					{
						document.getElementById('Day'+returns['id']).style.display = "none";
					}
				}
			}
		);
	}
}

function Day_Save()
{
	var params = new Object();
	params['title'] = document.getElementById('intitle').value;
	params['date'] = document.getElementById('indate').value;
	new Zikula.Ajax.Request(
		"ajax.php?module=Worship&func=Days_save",
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
					Day_Clear();
				}
			}
		}
	);
}

function Day_Clear()
{
	document.getElementById('intitle').value = "";
	document.getElementById('indate').value = "";
}

