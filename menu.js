function initialization() {
  var code = localStorage.getItem('project_code');

  if(code == null){
    window.location.href = 'login.html';
  }
    localStorage.removeItem('project_code');
}



function individualReport(){
  localStorage.setItem('project_code','admin');
    window.open('individualReport.html');
}

function sessionReport(){
    var session = $('#session').val();
    window.location.href = 'index.php?job=download&session='+session;

}

$(document).ready(function(){
    $.get('index.php?job=getSessions').done(function(result) {
    var sessions = result;
    if(sessions != false) {
      console.log(sessions);
      appendSession(sessions);
    }
    else
    {
      alert("Error: unexpected OR database is empty");
    }
    })
})
function appendSession(sessions) {
  var dest = document.getElementById('session');
  var option;
  
  for(var i=0; i<sessions.length; i++) {
    option = document.createElement("option");
    option.text=sessions[i].session;
    option.value=sessions[i].session;
    dest.add(option);
  }
}

function logOut() {
  window.location.href = 'login.html';
}

function settings() {
  localStorage.setItem('project_code','admin');
  window.location.href = 'settings.html';
}