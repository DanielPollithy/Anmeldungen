<?php

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

$mail_sender_name = 'Joschko Ruppersberg';
$mail_sender_address = 'joschko.ruppersberg@pfadfinden.de';
$about_participant_form_url = 'http://joschko.km20616-23.keymachine.de/Anmeldungen/about_participant.php?token=';
$pdf_repository = 'files/';

function send_template_mail($recipient, $template) {	
	$empfaenger = $recipient;
	$betreff = "Die Mail-Funktion";
	$from = "From: {$GLOBALS['mail_sender_name']} <{$GLOBALS['mail_sender_address']}>\n";
	$from .= "Reply-To: {$GLOBALS['mail_sender_address']}\n";
	$from .= "Content-Type: text/html\n";
	$text = include($template);
	mail($empfaenger, $betreff, $text, $from);
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

function makeFdf($makeFdf, $data)
{
    $fdf = '%FDF-1.2
    1 0 obj<</FDF<< /Fields[';

    foreach ($data as $key => $value) {
        $fdf .= '<</T(' . $key . ')/V(' . $value . ')>>';
    }

    $fdf .= "] >> >>
    endobj
    trailer
    <</Root 1 0 R>>
    %%EOF";

    file_put_contents($makeFdf, $fdf);
}

function fill_pdf($fdf_path, $pdf_path, $pdf_target_path) {
	$output = shell_exec("pdftk $pdf_path fill_form $fdf_path output '$pdf_target_path' flatten");
}

function get_secret() {
	$bytes = openssl_random_pseudo_bytes(50, $cstrong);
	$token   = bin2hex($bytes);
	return $token;
}

function save_participant_pdf($course, $groupname, $firstname, $lastname, $data) {
	$uuid = uniqid();
	$filename = $GLOBALS['pdf_repository'] . $course . "/" . "$firstname $lastname $groupname {$uuid}.pdf";
	echo $filename;
	if (!file_exists($GLOBALS['pdf_repository'] . $course)) {
		mkdir($GLOBALS['pdf_repository'] . $course, 0777, true);
	}
	pdf_to_fdf("Participant.pdf", "Participant.fdf");
	$form_data = $data; //array_intersect_key($my_array, array_flip(['firstname', 'lastname', 'nickname', 'birthdate', 'zip', 'city']));
	makeFdf("Participant.fdf", $form_data);
	fill_pdf("Participant.fdf", "Participant.pdf", $filename);
}




