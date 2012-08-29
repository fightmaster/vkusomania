$(document).ready(function(){

    $('.item .delete').click(function(){

        var elem = $(this).closest('.item');

        $.confirm({
            'title'	: 'Регистрация',
            'message'	: '<div class="regform">Введите ФИО:<font color="#FF0000"> *</font><br><input name="FIO" id="FIO" size="30">  <br>'+
            'Логин:<font color="#FF0000"> *</font><br><INPUT  name="Login" id="Login" size="30"><br>'+
            'Пароль:<font color="#FF0000"> *</font><br><INPUT type=password name="Pass" id="Pass" size="30" ><br>'+
            '<span lang="en-us">E-Mail:</span><font color="#FF0000"> *</font><br><INPUT name="Email" id="Email" size="30" ><br><br><div id="asyncResult" class="result"> </div></div>',
            'buttons'	: {
                'Регистрация'	: {
                    'class'	: 'blue',
                    'action': function(){
                        showAsyncRequest();
                        Stop();
                    }
                },
                'Выход'	: {
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
    var FIO   = document.getElementById("FIO").value;
    var Login = document.getElementById("Login").value;
    var Pass  = document.getElementById("Pass").value;
    var Email = document.getElementById("Email").value;
    var url = "../src/Reg/reg.php?fio=" + FIO + "&login=" + escape(Login)+ "&pass=" + escape(Pass)+ "&email=" + escape(Email);
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
        document.getElementById("FIO").value = "";
        document.getElementById("Login").value = "";
        document.getElementById("Pass").value = "";
        document.getElementById("Email").value = "";

    }	
}
	
function refresh()
{
    window.location='index.php'
}