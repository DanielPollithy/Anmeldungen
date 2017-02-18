<?php 

// This file shall only be executable from the bash
if (false){//(!$argv[1] || !($argv[1] == "RUN")) {
	exit();
}

include("db.php");

$groups = get_reminder_list();

// for every group there is a key in the array...
foreach ($groups as $groupname => $rows) {	
	// ... and the value is an array containing participants with missing values
	$mail = $rows[0][1];
	// a consolidated email shall remind the groupleader once in a while
	send_reminder_mail($mail, $groupname, $rows);
	error_log("Remindermail sent to $groupname $mail with data");
	error_log(grab_dump($rows));	
}

?>