<?php 

// TODO: check with code, that script was started by cron job

include("db.php");

$groups = get_reminder_list();

foreach ($groups as $groupname => $rows) {	
	$mail = $rows[0][1];
	send_reminder_mail($mail, $groupname, $rows);
	error_log("Remindermail sent to $groupname $mail with data");
	error_log(grab_dump($rows));
	
}

?>