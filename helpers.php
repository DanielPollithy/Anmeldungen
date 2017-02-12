<?php

$mail_sender_name = 'Joschko Ruppersberg';
$mail_sender_address = 'joschko.ruppersberg@pfadfinden.de';

function send_template_mail($recipient, $template) {	
	$empfaenger = $recipient;
	$betreff = "Die Mail-Funktion";
	$from = "From: {$GLOBALS['mail_sender_name']} <{$GLOBALS['mail_sender_address']}>\n";
	$from .= "Reply-To: {$GLOBALS['mail_sender_address']}\n";
	$from .= "Content-Type: text/html\n";
	$text = include("Emails/receipt.php");
	mail($empfaenger, $betreff, $text, $from);
}

function send_receipt_mail($recipient) {
	send_template_mail($recipient, "Emails/receipt.php");
}

function pdf_to_fdf($pdf_path, $fdf_path) {	
	$output = shell_exec("pdftk $pdf_path generate_fdf output $fdf_path");	
}

// http://www.pentco.com/test/
function createFDF($file,$info){
    $data="%FDF-1.2\n%âãÏÓ\n1 0 obj\n<< \n/FDF << /Fields [ ";
    foreach($info as $field => $val){
        if(is_array($val)){
            $data.='<</T('.$field.')/V[';
            foreach($val as $opt)
                $data.='('.trim($opt).')';
            $data.=']>>';
        }else{
            $data.='<</T('.$field.')/V('.trim($val).')>>';
        }
    }
    $data.="] \n/F (".$file.") /ID [ <".md5(time()).">\n] >>".
        " \n>> \nendobj\ntrailer\n".
        "<<\n/Root 1 0 R \n\n>>\n%%EOF\n";
    return $data;
}

function fill_fdf($fdf_path, $data) {
	$fdf = fdf_open("$fdf_path");
	$band = fdf_get_value($fdf, "band");
	fdf_set_value($fdf, "feldname", "wert");
	fdf_close($fdf);
}

function merge_fdf_and_pdf($fdf_path, $pdf_path, $pdf_target_path) {
	echo "pdftk $pdf_path fill_form $fdf_path output $pdf_target_path";
	$output = shell_exec("pdftk $pdf_path fill_form $fdf_path output $pdf_target_path");
}

merge_fdf_and_pdf("1.fdf", "1.pdf", "target.pdf");
