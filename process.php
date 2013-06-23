
<?php
	require_once "google-api-php-client/src/Google_Client.php";
  	//require_once "google-api-php-client/src/contrib/Google_PlusService.php";
  	require_once "google-api-php-client/src/contrib/Google_CalendarService.php";

  	$client = new Google_Client();
	$client->setApplicationName("ECS Vacations");

	// Visit https://code.google.com/apis/console?api=calendar to generate your
	// client id, client secret, and to register your redirect uri.
	$client->setClientId('236774995043-7t8a41ueito2j33n0qk7ib4bpev68dkc.apps.googleusercontent.com');
	$client->setClientSecret('mfHi7WMjjKnqBEwXFL5438mc');
	$client->setRedirectUri('http://localhost/vacations/process.php');
	//$client->setDeveloperKey('AIzaSyCyKQXFpvCizCwrqwGHefgRQBkO1t8O9Ig');

	$cal = new Google_CalendarService($client);
	if (isset($_GET['logout'])) {
	  unset($_SESSION['token']);
	}

	if (isset($_GET['code'])) {
	  $client->authenticate($_GET['code']);
	  $_SESSION['token'] = $client->getAccessToken();
	  header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
	}

	if (isset($_SESSION['token'])) {
	  $client->setAccessToken($_SESSION['token']);
	}

	if ($client->getAccessToken()) {
		echo "bah";
		die();
	  // Creating the google_Event
	  $createdEvent = $cal->events->insert('primary', $google_event);


	$_SESSION['token'] = $client->getAccessToken();
	} else {
	  $authUrl = $client->createAuthUrl();
	  print "<a class='login' href='$authUrl'>Connect Me!</a>";
	}

	$empName = $_POST['empName'];
    $vacType = $_POST['vacType'];
    $vacDates = $_POST['vacDates'];
    $vacDetails = $_POST['vacDetails'];
    // vacation calendar email found on google calendar under the 'Calendar Address' field.
    $calendarEmail = "4lcatq0emki0102kbqmd95ls24@group.calendar.google.com";

    $google_event = new google_Event();
    // Setting Event Title:
    $google_event->setSummary($empName.'Vacation');

    $start = new Google_EventDateTime();
    $end = new Google_EventDateTime();
    // Date String Manipulation  (mm/dd/yyyy) to (yyyy-mm-dd)
    // $vacDates = "06/11/2013 - 06/17/2013";
    $startDate = strtok($vacDates, "-");
    $endDate = $startDate;
    $endDate = strtok("-");
    $startDate= str_replace('/','-',$startDate);
    $endDate = str_replace('/','-',$endDate);
    $endDate = ltrim($endDate);
    $startDate = rtrim($startDate);
    $startDate = substr($startDate,-4)."-"."$startDate";
    $startDate = substr($startDate,0,strlen($startDate)-5);
    $endDate = substr($endDate,-4)."-"."$endDate";
    $endDate = substr($endDate,0,strlen($endDate)-5);

    // Setting Event Dates 
    $start->setDate($startDate);
    $end->setDate($endDate);
    $google_event->setStart($start);
    $google_event->setEnd($end);

    // Setting Event Attendee (Vacation Calendar Email)
    $attendee1 = new Google_EventAttendee();
	$attendee1->setEmail('calendarEmail');
	$attendees = array($attendee1);
	$google_event->attendees = $attendees;

	// Setting description of the google_event
	$google_event->description = "Vacation type:"."$vacType"."\r\n"."Vacation Details:-"."\r\n"."$vacDetails";

	//echo "Form submitted successfully: <br>Your name is <b>".$empName."</b> and your vacation dates is <b>".$_POST['vacDates']."</b><br>";
?>