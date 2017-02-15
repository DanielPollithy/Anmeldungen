<?php
$groupname = $GLOBALS['groupname'];
$participants = $GLOBALS['participants'];

$about_participant_form_url = $GLOBALS['about_participant_form_url'];

$tablebody = "";

foreach ($participants as $participant) {
	$group_name = $participant[0];
	$group_email = $participant[1];
	$firstname = $participant[2];
	$lastname = $participant[3];
	if ($participant[4] === NULL) {
		$participant_firm = "Fehlt";
	} else {
		$participant_firm = "Liegt vor";
	}
	if ($participant[5] === NULL) {
		$about_participant = "Liegt vor";
	} else {
		$url = $about_participant_form_url."".$participant[5];
		$about_participant = "<a href='$url'>Fehlt</a>";
	}	
	
	$tablebody = $tablebody . "
	<tr>
		<td>$firstname $lastname</td>
		<td>$participant_firm</td>
		<td>$about_participant</td>
	</tr>
	";
	
}

return "
Liebe Stammesleitung von $groupname, <br>
die folgende Auflistung soll euch eine hilfreiche Gedächtnisstütze sein:
<br>
<table style='width:100%;'>
	<tr>
		<th>Mitglied</th>
		<th>Anmeldung unterschrieben in GS?</th>
		<th>Zusatzinfos von Stammesleitung</th>
	</tr>
	$tablebody
</table>
Gut Pfad<br>
Joschko
";