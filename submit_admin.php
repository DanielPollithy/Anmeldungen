<?php

include("db.php");

// administration is secured by .htaccess
// and this site is secured by a one time random token generated for the administration site
if (! array_key_exists("access_secret", $_POST)) {
	echo "no access token";
	error_log("submit_admin.php without access_secret");
	exit();
}
// validate the access token
validate_access_secret($_POST['access_secret']);

// check if any changes were checked (checkboxes)
if (! array_key_exists("ids", $_POST)) {
	echo "no ids";
	error_log("submit_admin.php without ids[]");
	exit();
}

// if the checkbox of a line is activated, the date field of that line has to be filled out
foreach ($_POST['ids'] as $id) {
	if (!array_key_exists("date-$id", $_POST) || empty($_POST["date-$id"])) {
		echo "Missing date or empty date for id=$id";
		error_log("submit_admin.php Missing date or empty date");
		exit();
	}
}

// apply changes
foreach ($_POST['ids'] as $id) {
	// TODO: validate date
	reveived_firmed_application($id, $_POST["date-$id"]);
}

?>

<b>Änderungen eingetragen!</b>