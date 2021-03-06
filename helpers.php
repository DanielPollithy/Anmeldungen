<?php

// everything shall be logged
ini_set("log_errors", 1);
// the function error_log shall write to the given path
ini_set("error_log", "php-error.log");

// TODO: move this to a config file (classic or YAML)
// email config
$mail_sender_name = 'Joschko Ruppersberg';
$mail_sender_address = 'joschko.ruppersberg@pfadfinden.de';

// this url is used to build hyperlinks
$about_participant_form_url = 'http://joschko.km20616-23.keymachine.de/Anmeldungen/about_participant.php?token=';

// this url is used to build hyperlinks
$main_url = 'http://joschko.km20616-23.keymachine.de/Anmeldungen/';

// in this $main_url . $pdf_repository the pdfs shall be stored
$pdf_repository = 'files/';

// the .fdf temporary files are stored here
// shall not(!) be servable
$unserved_temp_dir = '/home/users/joschko/tmp';

// no http parameter shall be longer than this
$max_string_length = 2000;

// send an email to the recipient and use the template .php-file
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

// send this mail when a participant has signed up
function send_receipt_mail($recipient) {
	send_template_mail($recipient, "Emails/receipt.php");
}

// when a participant has signed up, send this mail to his or her groupleader
function send_token_to_groupleader($recipient, $groupname, $participant_firstname, $participant_lastname, $participant_course, $token) {
	$GLOBALS['groupname'] = $groupname;
	$GLOBALS['participant_firstname'] = $participant_firstname;
	$GLOBALS['participant_lastname'] = $participant_lastname;
	$GLOBALS['participant_course'] = $participant_course;
	$GLOBALS['token'] = $token;
	send_template_mail($recipient, "Emails/token_to_groupleader.php");
}

// used for the consolidated data for the groupleader
function send_reminder_mail($recipient, $groupname, $participants) {
	$GLOBALS['groupname'] = $groupname;
	$GLOBALS['participants'] = $participants;
	send_template_mail($recipient, "Emails/reminder_mail.php");
}

// generate a fdf file from a pdf formular
// fdf files only contain the name and the value of formular fields
function pdf_to_fdf($pdf_path, $fdf_path) {	
	$output = shell_exec("pdftk $pdf_path generate_fdf output $fdf_path");	
	echo $output;
}

// TODO: prevent fdf injection in user input
// Generated a fdf file and stores it in the temp/ directory which can be adjusted in the configs
// returns the filepath to the temporary fdf file 
// $data shall be a not nested mapping
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

// Merges a FDF-file and the matching PDF-File 
// -> filles it out and saves it to the $pdf_target_path
function fill_pdf($fdf_path, $pdf_path, $pdf_target_path) {
	$output = shell_exec("pdftk $pdf_path fill_form $fdf_path output '$pdf_target_path' flatten");
	error_log("shell_exec: $output");
}

// generate a "random" string with 100 bytes
function get_secret() {
	$bytes = openssl_random_pseudo_bytes(50, $cstrong);
	$token   = bin2hex($bytes);
	return $token;
}

// generate a string with 2*$n bytes
function get_n_secret($n) {
	$bytes = openssl_random_pseudo_bytes($n, $cstrong);
	$token = bin2hex($bytes);
	return $token;
}

// save the application of a participant to a pdf
// returns the "secret" absolute URL
function save_participant_pdf($course, $groupname, $firstname, $lastname, $data) {
	// $uuid for "security reasons"
	$uuid = get_n_secret(15);
	// TODO: generate filepath in a good way
	$filename = $GLOBALS['pdf_repository'] . $course . "/" . "$firstname $lastname $groupname---{$uuid}.pdf";
	// generate directory if it does not exist
	if (!file_exists($GLOBALS['pdf_repository'] . $course)) {
		mkdir($GLOBALS['pdf_repository'] . $course, 0777, true);
	}
	$form_data = $data;
	$tmpfname = makeFdf($form_data);
	fill_pdf($tmpfname, "pdfs/Participant.pdf", $filename);
	// delete temp file
	unlink($tmpfname);
	error_log("Filled participant PDF saved to {$GLOBALS['main_url']}{$filename}");
	return $GLOBALS['main_url'].$filename;
}

// save the information about the participant to a pdf
// returns the "secret" absolute URL
function save_about_participant_pdf($course, $groupname, $firstname, $lastname, $data) {
	$uuid = get_n_secret(15);
	$filename = $GLOBALS['pdf_repository'] . $course . "/" . "ABOUT-$firstname $lastname $groupname---{$uuid}.pdf";
	if (!file_exists($GLOBALS['pdf_repository'] . $course)) {
		mkdir($GLOBALS['pdf_repository'] . $course, 0777, true);
	}
	$form_data = $data;
	$tmpfname = makeFdf($form_data);
	fill_pdf($tmpfname, "pdfs/About_participant.pdf", $filename);
	// delete temp file
	unlink($tmpfname);
	error_log("Filled about participant PDF saved to {$GLOBALS['main_url']}{$filename}");
	return $GLOBALS['main_url'].$filename;
}




