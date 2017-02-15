<?php

include("db.php");


// awaited POST params
$fields = ["firstname", "lastname", "nickname", "birthdate", "zip", "city", "groupname", "street", "streetnumber",
	"cellphone", "email", "information", "train_benefit", "closest_train_station", "course", 		
	"member_since_year",  "attended_courses",
	"my_function", "justification_for_my_function", "special_about_my_group", "biggest_challenge_in_my_group",
	"my_expectations", "want_to_learn"];
	
$checkboxes = ["foto_publications_website", "foto_publications_socialmedia", "foto_publications_print_and_info",
	"has_kubalibre"];

	
// check if all field values are in $_POST
foreach ($fields as $fieldname) {
	if (!array_key_exists($fieldname, $_POST)) {
		echo "Missing parameter: ".$fieldname;
		error_log("Received a form with missing parameter:".$fieldname);
		exit();
	}
	if (strlen($_POST[$fieldname]) >= $GLOBALS['max_string_length']) {
		echo "String too long: $fieldname";
		error_log("String too long: $fieldname");
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

// Extract $grundkurs_additional from $_POST['course'] if it starts with "GK_"
if (0 === strpos($_POST['course'], 'GK_')) {
	$grundkurs_additional = str_replace("GK_", "", $_POST['course']);
} else {
	$grundkurs_additional = "";
}

// Copy over wanted $_POST values
$temp = array();
foreach (array_merge($checkboxes, $fields) as $key) {
	$temp[$key] = $_POST[$key];
}
$_POST = $temp;

// Access token for group_leader
$token = get_secret();

// TODO: text validation
add_participant($_POST['firstname'], $_POST['lastname'], $_POST['nickname'], $_POST['birthdate'], 
	$_POST['zip'], $_POST['city'], $_POST['groupname'], $_POST['street'], $_POST['streetnumber'],
	$_POST['cellphone'], $_POST['email'], $_POST['information'], $_POST['train_benefit'], $_POST['closest_train_station'], 
	$_POST['course'], $grundkurs_additional, $_POST['foto_publications_website'], $_POST['foto_publications_socialmedia'], 
	$_POST['foto_publications_print_and_info'], $_POST['member_since_year'], 
	$_POST['has_kubalibre'], $_POST['attended_courses'], $_POST['my_function'], $_POST['justification_for_my_function'], 
	$_POST['special_about_my_group'], $_POST['biggest_challenge_in_my_group'], $_POST['my_expectations'], 
	$_POST['want_to_learn'], $token);
	
//Find groupleader for the participant
$stafue_mail = get_email_by_group($_POST['groupname']);
	
// WARNING: this tool could be used as a spam-email-bot
send_receipt_mail($_POST['email']);
send_token_to_groupleader($stafue_mail, $_POST['groupname'], $_POST['firstname'], $_POST['lastname'], $_POST['course'], $token);

$_POST['grundkurs_additional'] = $grundkurs_additional;
$download_link = save_participant_pdf($_POST['course'], $_POST['groupname'], $_POST['firstname'], $_POST['lastname'], $_POST);
?>

<h2>Die nächsten Schritten:</h2>
<p>Um die Anmeldung rechtskräftig zu machen: Ausdrucken (<a href="<? echo $download_link; ?>">Druckversion</a>, Foto drauf und abschicken an:</p>
<p>BdP LV Bayern e.V., Severinstr. 5, 81541 München</p>
<h2>Was passiert danach?</h2>
<p> Wenn Gabi aus der Geschäftsstelle deine schriftliche 
Anmeldung erhalten hat und deine Stafüs ihre Arbeit erledigt haben, 
bekommst du per E-Mail Bescheid. </p>



