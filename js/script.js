$(document).ready(function() {

    $('.item .delete').click(function() {

        var elem = $(this).closest('.item');

        $.confirm({
            'title'	: 'Регистрация',
            'message':'<div class="regform">Введите Имя:<font color="#FF0000"> *</font><br><input name="Name" id="Name" size="30">  <br>'+
            'Фамилия:<font color="#FF0000"> *</font><br><INPUT  name="Surname" id="Surname" size="30"><br>'+
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

function showAsyncRequest() {
    
    var Name   = document.getElementById("Name").value;
	var Surname = document.getElementById("Surname").value;
    var Login = document.getElementById("Login").value;
    var Pass  = document.getElementById("Pass").value;
    var Email = document.getElementById("Email").value;
    
    $.post("index.php", {
        name: Name, 
		surname: Surname,
        login: Login, 
        password: Pass, 
        email: Email
    },
    function(data) {
        document.getElementById("asyncResult").innerHTML = data;
        document.getElementById("Name").value = "";
		document.getElementById("Surname").value = "";
        document.getElementById("Login").value = "";
        document.getElementById("Pass").value = "";
        document.getElementById("Email").value = "";
    });
}
	
function refresh() {
    window.location='index.php';
}