<?php

include("db.php");

if (! array_key_exists("access_secret", $_POST)) {
	echo "no access token";
	error_log("submit_admin.php without access_secret");
	exit();
}

validate_access_secret($_POST['access_secret']);

if (! array_key_exists("ids", $_POST)) {
	echo "no ids";
	error_log("submit_admin.php without ids[]");
	exit();
}

foreach ($_POST['ids'] as $id) {
	if (!array_key_exists("date-$id", $_POST) || empty($_POST["date-$id"])) {
		echo "Missing date or empty date for id=$id";
		error_log("submit_admin.php Missing date or empty date");
		exit();
	}
}

error_log("Make administrative changes");
error_log(grab_dump($_POST));

foreach ($_POST['ids'] as $id) {
	// TODO: validate date
	reveived_firmed_application($id, $_POST["date-$id"]);
}

?>

<b>Änderungen eingetragen!</b>