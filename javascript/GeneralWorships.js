function GeneralWorships_Del(id)
{
	var params = new Object();
	params['id'] = id;
	if(confirm("Soll der Gottesdienst wirklich gelöscht werden?"))
	{
		new Zikula.Ajax.Request(
			"ajax.php?module=Worship&func=GeneralWorships_Del",
			{
				parameters: params,
				onComplete:	function (ajax) 
				{
					var returns = ajax.getData();
					
					if(returns['id'])
					{
						document.getElementById('GeneralWorship'+returns['id']).style.display = "none";
					}
				}
			}
		);
	}
}

function GeneralWorships_Save()
{
	var params = new Object();
	params['day'] = document.getElementById('inday').value;
	params['time'] = document.getElementById('intime').value;
	params['title'] = document.getElementById('intitle').value;
	params['church'] = document.getElementById('inchurch').value;
	new Zikula.Ajax.Request(
		"ajax.php?module=Worship&func=GeneralWorships_save",
		{
			parameters: params,
			onComplete:	function (ajax) 
			{
				var returns = ajax.getData();
				if(returns['text']!="")
					alert(returns['text']);
				if(returns['ok']==1)
				{
					document.getElementById("List").innerHTML = returns['list'];
					GeneralWorships_Clear();
				}
			}
		}
	);
}

function GeneralWorships_Clear()
{
	document.getElementById('inday').value = "";
	document.getElementById('intime').value = "";
	document.getElementById('intitle').value = "";
	document.getElementById('inchurch').value = "";
}

function GeneralWorships_State(id, state)
{
	var params = new Object();
	params['id'] = id;
	params['state'] = state;
	new Zikula.Ajax.Request(
		"ajax.php?module=Worship&func=GeneralWorships_State",
		{
			parameters: params,
			onComplete:	function (ajax) 
			{
				var returns = ajax.getData();
				
				if(returns['id'])
				{
					if(returns['state']==1)
					{
						document.getElementById('GeneralWorship'+returns['id']).style.background = "";
						document.getElementById('GeneralWorshipLinkred'+returns['id']).style.display = "inline";
						document.getElementById('GeneralWorshipLinkgreen'+returns['id']).style.display = "none";
					}
					else
					{
						document.getElementById('GeneralWorship'+returns['id']).style.background = "linear-gradient(#FAFAFA, #DFDFDF) repeat scroll 0 0 rgba(0, 0, 0, 0)";
						document.getElementById('GeneralWorshipLinkred'+returns['id']).style.display = "none";
						document.getElementById('GeneralWorshipLinkgreen'+returns['id']).style.display = "inline";
					}
				}
			}
		}
	);
}

