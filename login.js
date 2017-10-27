function initialization() {
    localStorage.removeItem('project_code')
}

$(document).ready(function(){
    $("#name").keypress(function(event){
        if(event.keyCode == 13){
            $("#login").click();
        }
    });

    $("#password").keypress(function(event){
        if(event.keyCode == 13){
            $("#login").click();
        }
    });
});

function login() {
    $.get('login.php?job=admin&name='+$("#name").val()+'&code='+md5($("#password").val())).done(function(result) {
        if(result == 'Admin In') {
            localStorage.setItem('project_code',$('#password').val());
            window.location.href = 'menu.html';
        }
        else
        {
        alert('Invalid combination of name and password');
        }
    })
    console.log(md5($("#password").val()));

}