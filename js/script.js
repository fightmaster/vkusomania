$(document).ready(function(){

	$('.item .delete').click(function(){

		var elem = $(this).closest('.item');

		$.confirm({
			'title'		: 'Загрузка меню',
			'message'	: 'Введите логин:<br><input type="text" id="login" size="55" '+
						  'name="login" value=""><br>'+
			              '<br>Введите пароль:<br><input type="password" id="pass" size="55" '+
						  'name="pass" value="">',

			'buttons'	: {
				'Отправить'	: {
					'class'	: 'blue',
					'action': function(){
					showAsyncRequest();
					}
				},
				'Отмена'	: {
					'class'	: 'gray',
					'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
				}
			}
		});
	});
});

	function getXmlHttpRequest()
	{
		if (window.XMLHttpRequest) 
		{
			try 
			{
				return new XMLHttpRequest();
			} 
			catch (e){}
		} 
		else if (window.ActiveXObject) 
		{
			try 
			{
				return new ActiveXObject('Msxml2.XMLHTTP');
			} catch (e){}
			try 
			{
				return new ActiveXObject('Microsoft.XMLHTTP');
			} 
			catch (e){}
		}
		return null;
	}
		
	function showAsyncRequest()
	{
		var login = document.getElementById("login").value;
		var pass = document.getElementById("pass").value;
		var url = "../src/Check/check.php?login=" + escape(login) + "&pass=" + escape(pass);
			
		req = getXmlHttpRequest();
		req.onreadystatechange = showAsyncRequestComplete;
		req.open("GET", url, true);
		req.send(null);
	}

	function showAsyncRequestComplete()
	{
		// только при состоянии "complete"
		if (req.readyState == 4) 
		{
			document.getElementById("asyncResult").innerHTML = req.responseText;
		}	
	}
	
	function refresh()
	{
		window.location='index.php'
	}


		
		// Завершение асинхронного запроса

		
