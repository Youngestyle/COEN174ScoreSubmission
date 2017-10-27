<?php
require "db_config.php";

// admin Username and Password
$adminUsername = 'admin';
$adminPassword = 'admin'; 

$method = $_SERVER['REQUEST_METHOD'];

header("Content-Type: application/json"); //php header function

//if request is GET
if($method == 'GET') {
  
  //get the job wanted by the user
  $job = $_GET['job'];
  
  if($job == 'clearEvaluations')
  {

    $sql = "TRUNCATE TABLE evaluations";

/*    if($dbh->exec($sql)){
      echo json_encode('All evaluations removed from database');
    }
    else
    {
      echo json_encode('ERROR: Unable to remove evaluations from database');
    }
    */
    $dbh->exec($sql);
    echo json_encode('All evaluations removed from database');
  }
  else if($job == 'clearProjects')
  {

    $sql = "TRUNCATE TABLE projects";

/*    if($dbh->exec($sql)){
      echo json_encode('All projects removed from database');
    }
    else
    {
      echo json_encode('ERROR: Unable to remove projects from database');
    }
    */
    $dbh->exec($sql);
    echo json_encode('All projects removed from database');
  }
  else if($job == 'clearAll')
  {
    $sql1 = "TRUNCATE TABLE evaluations";
    $sql2 = "TRUNCATE TABLE projects";

/*    if($dbh->exec($sql1)){
      $evaluations = 'All evaluations removed from database';
    }
    else
    {
      $evaluations = 'ERROR: Unable to remove evaluations from database';
    }

    if($dbh->exec($sql2)){
      $projects = 'All projects removed from database';
    }
    else
    {
      $projects = 'ERROR: Unable to remove projects from database';
    }
*/
    $dbh->exec($sql1);
    $dbh->exec($sql2);
    $evaluations = 'All evaluations removed from database';
    $projects = 'All projects removed from database';
    echo json_encode($evaluations.' & '.$projects);
  }
  else if($job == 'code')
  {
                $sql = "select Code, Title from projects";
            
            //fetch data
            //code from http://code.stephenmorley.org/php/creating-downloadable-csv-files/
            // output headers so that the file is downloaded rather than displayed
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=presentationCode.csv');

            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

                fputcsv($output, array('Code','Title'));


                  //fetch data
                  $result = $dbh->query($sql);

                  while($row = $result->fetch()){
                    //loop over the rows, outputting them
                    for($i=0; $i<2; $i++) {
                      unset($row[$i]);
                    }
                    fputcsv($output, $row);
                  }
  }
    else if($job == 'template')
  {
                $sql = "select Code, Title from projects";
            
            //fetch data
            //code from http://code.stephenmorley.org/php/creating-downloadable-csv-files/
            // output headers so that the file is downloaded rather than displayed
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=template.csv');

            // create a file pointer connected to the output stream
            $output = fopen('php://output', 'w');

                fputcsv($output, array('Title','Description','Session','Time','Location','Category','EngineeringSeniors','Non-Engineers','First1','Last1','Phone1','Email1','Major1','First2','Last2','Major2','Phone2','Email2','First3','Last3','Phone3','Email3','Major3','First4','Last4','Phone4','Email4','Major4','First5','Last5','Phone5','Email5','Major5','First6','Last6','Phone6','Email6','Major6','PresentationMediaNeeds','TypeofPresentationComputerNeeded','BringingOwnLaptop?','MacModel','SoftwareNeeds','Showcasing?','ShowcasingSpace','ShowcasingNeeds','Faculty1','FacultyDept1','Faculty2','FacDept2','Faculty3','FacDept3','Faculty4','FacDept4','DateSubmitted'));
  }
      else if($job == 'changePassword')
  {
    $password = $_GET['password'];
    if (($handle = fopen("settings.csv", "r")) !== FALSE) {
          fgetcsv($handle);
          if (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
            file_put_contents('settings.csv', "password|conferenceDate\n".$password.'|'.$data[1]);
            echo json_encode('Password changed');
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
      else if($job == 'changeDate')
  {
    $date = $_GET['date'];
    if (($handle = fopen("settings.csv", "r")) !== FALSE) {
          fgetcsv($handle);
          if (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
            file_put_contents('settings.csv', "password|conferenceDate\n".$data[0].'|'.$date);
            echo json_encode('Conference date changed');
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
        else if($job == 'getDate')
  {
    if (($handle = fopen("settings.csv", "r")) !== FALSE) {
          fgetcsv($handle);
          if (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
            echo json_encode($data[1]);
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
else if($method == 'POST') {
  
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {

    $sql1 = "TRUNCATE TABLE evaluations";
    $sql2 = "TRUNCATE TABLE projects";

/*    if($dbh->exec($sql1)){
      $evaluations = 'All evaluations removed from database';
    }
    else
    {
      $evaluations = 'ERROR: Unable to remove evaluations from database';
    }

    if($dbh->exec($sql2)){
      $projects = 'All projects removed from database';
    }
    else
    {
      $projects = 'ERROR: Unable to remove projects from database';
    }
*/
    $dbh->exec($sql1);
    $dbh->exec($sql2);

        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $_FILES['file']['name']);
        $fileName = 'uploads/' . $_FILES['file']['name'];
        
        if (($handle = fopen($fileName, "r")) !== FALSE) {
          fgetcsv($handle);
          $flag = 0;
          $counter = 0;   
          while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
            $counter++;
            //0-54
          // SQL Query to insert data into DataBase

          //generate a random 6 digit code
          $pinlength = 6;
          $charSet = '23456789ABCDEFGHJKLMNPRSTVWXYZ'; 
          do {
            $pin = '';
            for($a = 0; $a < $pinlength; $a++) $pin .= $charSet[rand(0, strlen($charSet)-1)];
            $search = "select * from projects where code='".$pin."'";
            $search_result = $dbh->query($search);
          }while($row = $search_result->fetch());
          

          $sql = "INSERT INTO projects (Code,Title,Description,Session,Time,Location,Category,EngineeringSeniors,NonEngineers,First1,Last1,Phone1,Email1,Major1,First2,Last2,Major2,Phone2,Email2,First3,Last3,Phone3,Email3,Major3,First4,Last4,Phone4,Email4,Major4,First5,Last5,Phone5,Email5,Major5,First6,Last6,Phone6,Email6,Major6,PresentationMediaNeeds,TypeofPresentationComputerNeeded,BringingOwnLaptop,MacModel,SoftwareNeeds,Showcasing,ShowcasingSpace,ShowcasingNeeds,Faculty1,FacultyDept1,Faculty2,FacDept2,Faculty3,FacDept3,Faculty4,FacDept4,DateSubmitted) VALUES (:Code,:Title,:Description,:Session,:Time,:Location,:Category,:EngineeringSeniors,:NonEngineers,:First1,:Last1,:Phone1,:Email1,:Major1,:First2,:Last2,:Major2,:Phone2,:Email2,:First3,:Last3,:Phone3,:Email3,:Major3,:First4,:Last4,:Phone4,:Email4,:Major4,:First5,:Last5,:Phone5,:Email5,:Major5,:First6,:Last6,:Phone6,:Email6,:Major6,:PresentationMediaNeeds,:TypeofPresentationComputerNeeded,:BringingOwnLaptop,:MacModel,:SoftwareNeeds,:Showcasing,:ShowcasingSpace,:ShowcasingNeeds,:Faculty1,:FacultyDept1,:Faculty2,:FacDept2,:Faculty3,:FacDept3,:Faculty4,:FacDept4,:DateSubmitted)";

          $stmt = $dbh->prepare($sql);
          //bind the parameters

          $stmt->bindParam(':Code', $pin);
          $stmt->bindParam(':Title', $data[0]);
          $stmt->bindParam(':Description', $data[1]);
          $stmt->bindParam(':Session', $data[2]);
          $stmt->bindParam(':Time', $data[3]);
          $stmt->bindParam(':Location', $data[4]);
          $stmt->bindParam(':Category', $data[5]);
          $stmt->bindParam(':EngineeringSeniors', $data[6]);
          $stmt->bindParam(':NonEngineers', $data[7]);
          $stmt->bindParam(':First1', $data[8]);
          $stmt->bindParam(':Last1', $data[9]);
          $stmt->bindParam(':Phone1', $data[10]);
          $stmt->bindParam(':Email1', $data[11]);
          $stmt->bindParam(':Major1', $data[12]);
          $stmt->bindParam(':First2', $data[13]);
          $stmt->bindParam(':Last2', $data[14]);
          $stmt->bindParam(':Major2', $data[15]);
          $stmt->bindParam(':Phone2', $data[16]);
          $stmt->bindParam(':Email2', $data[17]);
          $stmt->bindParam(':First3', $data[18]);
          $stmt->bindParam(':Last3', $data[19]);
          $stmt->bindParam(':Phone3', $data[20]);
          $stmt->bindParam(':Email3', $data[21]);
          $stmt->bindParam(':Major3', $data[22]);
          $stmt->bindParam(':First4', $data[23]);
          $stmt->bindParam(':Last4', $data[24]);
          $stmt->bindParam(':Phone4', $data[25]);
          $stmt->bindParam(':Email4', $data[26]);
          $stmt->bindParam(':Major4', $data[27]);
          $stmt->bindParam(':First5', $data[28]);
          $stmt->bindParam(':Last5', $data[29]);
          $stmt->bindParam(':Phone5', $data[30]);
          $stmt->bindParam(':Email5', $data[31]);
          $stmt->bindParam(':Major5', $data[32]);
          $stmt->bindParam(':First6', $data[33]);
          $stmt->bindParam(':Last6', $data[34]);
          $stmt->bindParam(':Phone6', $data[35]);
          $stmt->bindParam(':Email6', $data[36]);
          $stmt->bindParam(':Major6', $data[37]);
          $stmt->bindParam(':PresentationMediaNeeds', $data[38]);
          $stmt->bindParam(':TypeofPresentationComputerNeeded', $data[39]);
          $stmt->bindParam(':BringingOwnLaptop', $data[40]);
          $stmt->bindParam(':MacModel', $data[41]);
          $stmt->bindParam(':SoftwareNeeds', $data[42]);
          $stmt->bindParam(':Showcasing', $data[43]);
          $stmt->bindParam(':ShowcasingSpace', $data[44]);
          $stmt->bindParam(':ShowcasingNeeds', $data[45]);
          $stmt->bindParam(':Faculty1', $data[46]);
          $stmt->bindParam(':FacultyDept1', $data[47]);
          $stmt->bindParam(':Faculty2', $data[48]);
          $stmt->bindParam(':FacDept2', $data[49]);
          $stmt->bindParam(':Faculty3', $data[50]);
          $stmt->bindParam(':FacDept3', $data[51]);
          $stmt->bindParam(':Faculty4', $data[52]);
          $stmt->bindParam(':FacDept4', $data[53]);
          $stmt->bindParam(':DateSubmitted', $data[54]);


            if($stmt->execute()){
              $flag++;
              //echo "File data successfully imported to database!!";
              //echo json_encode($stmt->errorInfo());
            }
            else
            {
              //echo "ERROR: Unable to insert into database";
              //echo json_encode($stmt->errorInfo());
            }
          }
          if($counter==$flag)
          {
            echo "File data successfully imported to database!!";
          }
          else
          {
            echo "ERROR: Unable to insert into database";
          }
          fclose($handle);
          unlink($fileName);
        }

    }
    $dbh=null;
}


?>