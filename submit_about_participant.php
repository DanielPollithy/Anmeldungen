<?php

include("db.php");

// awaited POST params
$fields = ["group_leader_access_token", "group_leader_about_function", "group_leader_about_expectations", 
"group_leader_about_group_situation", 
"meuten_number", "meuten_participants_each", "meuten_annotations", 
"sippen_number", "sippen_participants_each", "sippen_annotations", 
"runden_number", "runden_participants_each", "runden_annotations", 
"misc_number", "misc_participants_each", "misc_annotations", 
"total_number", "total_participants_each", "total_annotations", 	
"group_leader_name", "group_leader_email", "group_leader_cellphone"
];

	
$checkboxes = ["fulfilles_profile", "group_provides_opportunities"];

	
// check if all field values are in $_POST
foreach ($fields as $fieldname) {
	if (!array_key_exists($fieldname, $_POST)) {
		echo "Missing parameter: ".$fieldname;
		error_log("submit_about_participant.php missing parameter:".$fieldname);
		exit();
	}
}

// check if checkbox is in $_POST, else add it with value=False
foreach ($checkboxes as $box) {
	if (!array_key_exists($box, $_POST)) {
		$_POST[$box] = false;
	} else {
		$_POST[$box] = true;
	}
}


add_info_about_participant(
		$_POST['group_leader_about_function'],
		$_POST['group_leader_about_expectations'],
		$_POST['group_leader_about_group_situation'],	
		$_POST['meuten_number'],
		$_POST['meuten_participants_each'],
		$_POST['meuten_annotations'],	
		$_POST['sippen_number'],
		$_POST['sippen_participants_each'],
		$_POST['sippen_annotations'],	
		$_POST['runden_number'],
		$_POST['runden_participants_each'],
		$_POST['runden_annotations'],	
		$_POST['misc_number'],
		$_POST['misc_participants_each'],
		$_POST['misc_annotations'],	
		$_POST['total_number'],
		$_POST['total_participants_each'],
		$_POST['total_annotations'],	
		$_POST['fulfilles_profile'],
		$_POST['group_provides_opportunities'],	
		$_POST['group_leader_name'],
		$_POST['group_leader_email'],
		$_POST['group_leader_cellphone'],	
		$_POST['group_leader_access_token']
);

// TODO: use validated data
// TODO: don't use $_POST
save_about_participant_pdf($_POST['course'], $_POST['groupname'], $_POST['firstname'], $_POST['lastname'], $_POST);

?>

Dankeschön!