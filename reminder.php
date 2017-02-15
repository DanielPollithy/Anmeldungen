<?php 

// This file shall only be executable from the bash
if (!$argv[1] || !($argv[1] == "RUN")) {
	exit();
}

include("db.php");

$groups = get_reminder_list();

foreach ($groups as $groupname => $rows) {	
	$mail = $rows[0][1];
	send_reminder_mail($mail, $groupname, $rows);
	error_log("Remindermail sent to $groupname $mail with data");
	error_log(grab_dump($rows));
	
}

?>