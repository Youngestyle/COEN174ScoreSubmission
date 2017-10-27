function initialization() {

  //get project code
  //localStorage.setItem('project_code',59);
  var code = localStorage.getItem('project_code');

  localStorage.setItem('project_temp_code',code);
  if(code == null){
    window.location.href = 'judge.html';
  }
  else
  {
    localStorage.removeItem('project_code');
    //get data from server
  $.get('index.php?job=get&code='+code).done(function(result) {
    var project = result;
    if(project != false) {
      changeDate();
      appendInfo(project);
    }
    else
    {
      alert("Error: Invalid Code");
      window.location.href = 'judge.html';
    }
  });
  }
 
}

function changeDate()
{
  $.get('settings.php?job=getDate').done(function(result) {
    if(result != null) {
      $("#conferenceDate").text(result);
    }
    else
    {
      alert("Error: unexpected");
    }
    })
}

function appendInfo(project) {
  document.getElementById('session').value = project.Session;
  document.getElementById('room#').value = project.Location;
  document.getElementById('projectTitle').value = project.Title;
  var names = "";
  for (var i=1; i<7; i++) {
    if(project['First'+i] != '') {
      names = names + project['First'+i] + ' ' + project['Last'+i] + ", ";
    }
    else
    {
      break;
    }
  }
  document.getElementById('groupMembers').value = names.substr(0, names.length - 2);

  names = "";
  for (var i=1; i<5; i++) {
    if(project['Faculty'+i] != '') {
      names = names + project['Faculty'+i] + ", "
    }
    else
    {
      break;
    }
  }
  document.getElementById('advisors').value = names.substr(0, names.length - 2);
}

function submit() {
  if(document.getElementById('judge').value == '') {
    alert('Please enter your name');
  }
  else {
    var list = document.getElementsByClassName('score');
    var flag = false;
    for (var i=0, len=list.length; i<len; i++) {
        if(list[i].value == 'NIL') {
            flag = true;
            break;
        }
    }
    if(flag) {
      alert('You have not completed the score sheet');
    }
    else
      {
      var r = confirm('Is your name \''+ document.getElementById('judge').value +'\'?');
      if(r) {
        r = confirm('Are you sure you want to submit the form?')
        if (r) {
          console.log('submit');
            var code = localStorage.getItem('project_temp_code');
            //fetch data from page and create a new object
            var newEva= {code:code,session:$('#session').val(),judge: $('#judge').val(),da: $('#DA').val(),db: $('#DB').val(),dc: $('#DC').val(),dd: $('#DD').val(),de: $('#DE').val(),df: $('#DF').val(),dg: $('#DG').val(),dh: $('#DH').val(),pa: $('#PA').val(),pb: $('#PB').val(),pc: $('#PC').val(),pd: $('#PD').val(),total: $('#GrandTotal').val(),economic:$('#economic').is(':checked'),environmental:$('#environmental').is(':checked'),sustainability:$('#sustainability').is(':checked'),manufacturability:$('#manufacturability').is(':checked'),ethical:$('#ethical').is(':checked'),healthandsafety:$('#healthandsafety').is(':checked'),social:$('#social').is(':checked'),political:$('#political').is(':checked'),comments:$('#comments').val()};
            var url = 'index.php?job=post&code='+newEva.code+'&session='+newEva.session+'&judge='+newEva.judge+'&da='+newEva.da+'&db='+newEva.db+'&dc='+newEva.dc+'&dd='+newEva.dd+'&de='+newEva.de+'&df='+newEva.df+'&dg='+newEva.dg+'&dh='+newEva.dh+'&pa='+newEva.pa+'&pb='+newEva.pb+'&pc='+newEva.pc+'&pd='+newEva.pd+'&total='+newEva.total+'&economic='+newEva.economic+'&environmental='+newEva.environmental+'&sustainability='+newEva.sustainability+'&manufacturability='+newEva.manufacturability+'&ethical='+newEva.ethical+'&healthandsafety='+newEva.healthandsafety+'&social='+newEva.social+'&political='+newEva.political+'&comments='+newEva.comments;
            console.log(url);
              $.get(url).done(function(result) {
                
                console.log(result);
                if(result == 'Evaluation Submitted Successfully'){
                  alert(result);
                  localStorage.removeItem('project_temp_code');
                    window.location.href = 'judge.html';
                }
                else if (result == 'Evaluation Submission Failed: Record already exists')
                {
                  r=confirm('Record already exists, do you wish to re-submit?')
                  if(r){
                    url = 'index.php?job=update&code='+newEva.code+'&session='+newEva.session+'&judge='+newEva.judge+'&da='+newEva.da+'&db='+newEva.db+'&dc='+newEva.dc+'&dd='+newEva.dd+'&de='+newEva.de+'&df='+newEva.df+'&dg='+newEva.dg+'&dh='+newEva.dh+'&pa='+newEva.pa+'&pb='+newEva.pb+'&pc='+newEva.pc+'&pd='+newEva.pd+'&total='+newEva.total+'&economic='+newEva.economic+'&environmental='+newEva.environmental+'&sustainability='+newEva.sustainability+'&manufacturability='+newEva.manufacturability+'&ethical='+newEva.ethical+'&healthandsafety='+newEva.healthandsafety+'&social='+newEva.social+'&political='+newEva.political+'&comments='+newEva.comments;
                    $.get(url).done(function(result) {
                      alert(result);
                      if(result == 'Update Successful') {
                        localStorage.removeItem('project_temp_code');
                        window.location.href = 'judge.html';
                      }
                    });
                  }
                }
                else
                {
                  alert("ERROR:"+result);
                }
              });
        }
      }
    }
  }
}

function add(a, b) {
  return a + b;
}

function changeInfo(){
  var code = localStorage.getItem('project_temp_code');
  var judge = $('#judge').val();
  if(judge != ''){
      $.get('index.php?job=getJudge&code='+code+'&judge='+judge).done(function(result) {
      var eva = result;
      if(eva != false) {
        console.log('changeInfo');
        console.log(eva);
        updateInfo(eva);
      }
      else
      {
        resetInfo();
      }
    });
  }
}

function resetInfo() {
  $('#DA').val('NIL');
  $('#DB').val('NIL');
  $('#DC').val('NIL');
  $('#DD').val('NIL');
  $('#DE').val('NIL');
  $('#DF').val('NIL');
  $('#DG').val('NIL');
  $('#DH').val('NIL');
  $('#PA').val('NIL');
  $('#PB').val('NIL');
  $('#PC').val('NIL');
  $('#PD').val('NIL');
  $( "#economic" ).prop( "checked", false);
  $( "#environmental" ).prop( "checked", false);
  $( "#sustainability" ).prop( "checked", false);
  $( "#manufacturability" ).prop( "checked", false);
  $( "#ethical" ).prop( "checked", false);
  $( "#healthandsafety" ).prop( "checked", false);
  $( "#social" ).prop( "checked", false);
  $( "#political" ).prop( "checked", false);
  $('#comments').val('');
  changeGrandTotal();
}

function updateInfo(eva) {
  $('#DA').val(eva.da);
  $('#DB').val(eva.db);
  $('#DC').val(eva.dc);
  $('#DD').val(eva.dd);
  $('#DE').val(eva.de);
  $('#DF').val(eva.df);
  $('#DG').val(eva.dg);
  $('#DH').val(eva.dh);
  $('#PA').val(eva.pa);
  $('#PB').val(eva.pb);
  $('#PC').val(eva.pc);
  $('#PD').val(eva.pd);
  $( "#economic" ).prop( "checked", eva.economic=== "true");
  $( "#environmental" ).prop( "checked", eva.environmental=== "true");
  $( "#sustainability" ).prop( "checked", eva.sustainability=== "true");
  $( "#manufacturability" ).prop( "checked", eva.manufacturability=== "true");
  $( "#ethical" ).prop( "checked", eva.ethical=== "true");
  $( "#healthandsafety" ).prop( "checked", eva.healthandsafety=== "true");
  $( "#social" ).prop( "checked", eva.social=== "true");
  $( "#political" ).prop( "checked", eva.political=== "true");
  $('#comments').val(eva.comments);
  changeGrandTotal();
}

function changeGrandTotal() {
    var list = document.getElementsByClassName('score');
    var sum = 0;
    for (var i=0, len=list.length; i<len; i++) {
        if(Number.isInteger(parseInt(list[i].value))) {
            sum += parseInt(list[i].value);
        }
            
    }
    document.getElementById('GrandTotal').value = sum;
}