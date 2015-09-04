<?php
require 'autoload.php';

 require 'src\Parse\ParseClient.php';
 require 'src\Parse\ParseObject.php';
 require 'src\Parse\ParseQuery.php';
 //require  'src\Parse\ParseObject.php';

 Parse\ParseClient::initialize('yourkey','yourkey', 'yourkey');

 try{
 $query = new Parse\ParseQuery("tablename");
$query->descending("column_name");
$query->limit('1');
 //$query->equalTo("objectId", "RFyDtYzQNv");
$results = $query->find();
///to find month and year
$month=date('M');

if($month=='Jan')
{

$year= date('Y', strtotime('last year'));

}
 else
     {
    $year= date('Y');    
}
echo $year;

foreach($results as $row){ 
    $deviceToken = $row->deviceToken; // field name : deviceToken
    $starCount = $row->starCount;	// field name : starCount
    $videoTitle = $row->videoTitle;	// field name : videoTitle
    $videoTotalDuretion = $row->videoTotalDuretion; 	// field name : videoTotalDuretion
    $videoDescription = $row->videoDescription;		// field name : videoDescription
    $videoUploadedOnMonthAndYear = $row->videoUploadedOnMonthAndYear;	// field name : videoUploadedOnMonthAndYear
        }
        
        } catch (Exception $e){
    echo $e->getMessage();
 }
 
 if(!empty($deviceToken))
 {
     $winnerentry = new Parse\ParseQuery("videoListTable");
     $winnerentry->equalTo("starCount", $starCount);
     $win = $winnerentry->first();
try {
 
  $win->set("status", 'winner');
  $win->set("winningPrice", '$50');
  $win->set("month", $month);
  $win->set("year",$year);

  
  $win->save();
  echo 'New object updated with objectId: ' . $win->getObjectId();
} catch (ParseException $ex) {  
  // Execute any logic that should take place if the save fails.
  // error is a ParseException object with an error code and message.
  echo 'Failed to create new object, with error message: ' . $ex->getMessage();
}
   echo '<script>window.location.href = "push4.php?deviceToken='.$deviceToken.'";</script>';
 }
   
?>