<?php

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

$mail_sender_name = 'Joschko Ruppersberg';
$mail_sender_address = 'joschko.ruppersberg@pfadfinden.de';
$about_participant_form_url = 'http://joschko.km20616-23.keymachine.de/Anmeldungen/about_participant.php?token=';
$main_url = 'http://joschko.km20616-23.keymachine.de/Anmeldungen/';
$pdf_repository = 'files/';
$unserved_temp_dir = '/home/users/joschko/tmp';
$max_string_length = 2000;

function send_template_mail($recipient, $template) {	
	$empfaenger = $recipient;
	$betreff = "Die Mail-Funktion";
	$from = "From: {$GLOBALS['mail_sender_name']} <{$GLOBALS['mail_sender_address']}>\n";
	$from .= "Reply-To: {$GLOBALS['mail_sender_address']}\n";
	$from .= "Content-Type: text/html\n";
	$text = include($template);
	mail($empfaenger, $betreff, $text, $from);
	error_log("Email ($template) sent to $recipient");
}

function send_receipt_mail($recipient) {
	send_template_mail($recipient, "Emails/receipt.php");
}

function send_token_to_groupleader($recipient, $groupname, $participant_firstname, $participant_lastname, $participant_course, $token) {
	$GLOBALS['groupname'] = $groupname;
	$GLOBALS['participant_firstname'] = $participant_firstname;
	$GLOBALS['participant_lastname'] = $participant_lastname;
	$GLOBALS['participant_course'] = $participant_course;
	$GLOBALS['token'] = $token;
	send_template_mail($recipient, "Emails/token_to_groupleader.php");
}

function send_reminder_mail($recipient, $groupname, $participants) {
	$GLOBALS['groupname'] = $groupname;
	$GLOBALS['participants'] = $participants;
	send_template_mail($recipient, "Emails/reminder_mail.php");
}

function pdf_to_fdf($pdf_path, $fdf_path) {	
	$output = shell_exec("pdftk $pdf_path generate_fdf output $fdf_path");	
}

// TODO: prevent fdf injection in user input
function makeFdf($data)
{
	$tmpfname = tempnam($GLOBALS['unserved_temp_dir'], "FDF");
    $temp = fopen($tmpfname, "w");
	$fdf = '%FDF-1.2
    1 0 obj<</FDF<< /Fields[';

    foreach ($data as $key => $value) {
		if (is_bool($value)) {
			if ($value) {
				$value = "Yes";
			} else {
				$value = "Off";
			}
		}
        $fdf .= '<</T(' . $key . ')/V(' . utf8_decode($value) . ')>>';
    }

    $fdf .= "] >> >>
    endobj
    trailer
    <</Root 1 0 R>>
    %%EOF";

    fwrite($temp, $fdf);
	fclose($temp);
	return $tmpfname;
}

function fill_pdf($fdf_path, $pdf_path, $pdf_target_path) {
	$output = shell_exec("pdftk $pdf_path fill_form $fdf_path output '$pdf_target_path' flatten");
}

function get_secret() {
	$bytes = openssl_random_pseudo_bytes(50, $cstrong);
	$token   = bin2hex($bytes);
	return $token;
}

function get_n_secret($n) {
	$bytes = openssl_random_pseudo_bytes($n, $cstrong);
	$token   = bin2hex($bytes);
	return $token;
}

function save_participant_pdf($course, $groupname, $firstname, $lastname, $data) {
	$uuid = get_n_secret(15);
	$filename = $GLOBALS['pdf_repository'] . $course . "/" . "$firstname $lastname $groupname---{$uuid}.pdf";
	if (!file_exists($GLOBALS['pdf_repository'] . $course)) {
		mkdir($GLOBALS['pdf_repository'] . $course, 0777, true);
	}
	$form_data = $data; //array_intersect_key($my_array, array_flip(['firstname', 'lastname', 'nickname', 'birthdate', 'zip', 'city']));
	$tmpfname = makeFdf($form_data);
	fill_pdf($tmpfname, "pdfs/Participant.pdf", $filename);
	unlink($tmpfname);
	error_log("Filled participant PDF saved to {$GLOBALS['main_url']}{$filename}");
	return $GLOBALS['main_url'].$filename;
}

function save_about_participant_pdf($course, $groupname, $firstname, $lastname, $data) {
	$uuid = get_n_secret(15);
	$filename = $GLOBALS['pdf_repository'] . $course . "/" . "ABOUT-$firstname $lastname $groupname---{$uuid}.pdf";
	if (!file_exists($GLOBALS['pdf_repository'] . $course)) {
		mkdir($GLOBALS['pdf_repository'] . $course, 0777, true);
	}
	$form_data = $data; //array_intersect_key($my_array, array_flip(['firstname', 'lastname', 'nickname', 'birthdate', 'zip', 'city']));
	$tmpfname = makeFdf($form_data);
	fill_pdf($tmpfname, "pdfs/About_participant.pdf", $filename);
	unlink($tmpfname);
	error_log("Filled about participant PDF saved to {$GLOBALS['main_url']}{$filename}");
	return $GLOBALS['main_url'].$filename;
}




