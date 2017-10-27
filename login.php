<?php
require "db_config.php";

// admin Username and Password
$adminUsername = 'admin';
$adminPassword = 'admin'; 

$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json"); //php header function

//all request are GET
if($method == 'GET') {
  
  //get the job wanted by the user
  $job = $_GET['job'];
  
  //check session code entered
  if($job == 'judge')
  {
    //get code of the project
    $code = $_GET['code'];

    $sql = "select * from projects where Code='".$code."'";
    
    //fetch data
    $result = $dbh->query($sql);
  
    if($result->fetch())
    {
      echo json_encode('Judge In');
    }
    else
    {
      echo json_encode('Invalid Pin');
    }
  }
  else if($job == 'admin')
  {
    $code = $_GET['code'];
    $name = $_GET['name'];

    if (($handle = fopen("settings.csv", "r")) !== FALSE) {
          fgetcsv($handle);
          if (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
            //default password to be admin
            if($name == $adminUsername && $code == $data[0])//md5($adminPassword))
            {
              echo json_encode('Admin In');
            }
            else
            {
              echo json_encode('Incorrect Login info');
            }
          }
          else
          {
            echo json_encode('Unexpected Error: empty setting file');
          }
    }
    else
    {
      echo json_encode('Unexpected Error: unable to read setting file');
    }
  }
    
    $dbh=null;
}


?>
