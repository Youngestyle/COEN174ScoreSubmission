function initialization() {
  var code = localStorage.getItem('project_code');

  if(code == null){
    window.location.href = 'login.html';
  }
    localStorage.removeItem('project_code');
}



function clearEvaluations(){
  var r = confirm('Are you sure you want to delete all evaluations?');
  if (r) {
    $.get('settings.php?job=clearEvaluations').done(function(result) {
      alert(result);
    })
  }
}

function clearProjects(){
  var r = confirm('Are you sure you want to delete all projects?');
  if (r) {
    $.get('settings.php?job=clearProjects').done(function(result) {
      alert(result);
    })
  }
}

function clearAll(){
  var r = confirm('Are you sure you want to delete all evaluations and projects?');
    if (r) {
      $.get('settings.php?job=clearAll').done(function(result) {
      alert(result)
    })
    }
}

function getCode(){
  window.location.href = 'settings.php?job=code';
}
function getTemplate()
{
  window.location.href = 'settings.php?job=template';
}

function upload(){
  var r = confirm('Are you sure you want to overwrite the database with the new data?');
    if (r) {

    var ext = $('#newPresentations').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['csv']) == -1) {
        alert('Invalid filetype! Must be .csv file');
    }
    else
    {
      var file_data = $('#newPresentations').prop('files')[0];   
      var form_data = new FormData();                  
      form_data.append('file', file_data);                            
      $.ajax({
                  url: 'settings.php', // point to server-side PHP script 
                  dataType: 'text',  // what to expect back from the PHP script, if anything
                  cache: false,
                  contentType: false,
                  processData: false,
                  data: form_data,                         
                  type: 'post',
                  success: function(php_script_response){
                      alert(php_script_response); // display response from the PHP script, if any
                      console.log(php_script_response);
                  }
        });
    }
  }
}

function back() {
  localStorage.setItem('project_code','admin');
  window.location.href = 'menu.html';
}

function changeDate(){
  var date = prompt("Please enter the new Conference Date", "MAY 12, 2016");
    if (date != null) {
        date = date.toUpperCase();
        $.get('settings.php?job=changeDate&date='+date).done(function(result) {
          alert(result)
        })
    }
    else
    {
      alert('Conference date did not change');
    }
}

function changePassword(){
  var newPassword = prompt("Please enter the new password");
    if (newPassword != null) {
        var confirmPassword = prompt("Please confirm the new password");
        if(confirmPassword === newPassword)
        {
          $.get('settings.php?job=changePassword&password='+md5(newPassword)).done(function(result) {
            alert(result)
          })
        }
        else
        {
          alert('Unable to change password, password entered do not match');
        }
    }
    else
    {
      alert('Password did not change');
    }
}