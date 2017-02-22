<?php

$groupname = $GLOBALS['groupname'];
$participant_firstname = $GLOBALS['participant_firstname'];
$participant_lastname = $GLOBALS['participant_lastname'];
$participant_course = $GLOBALS['participant_course'];
$token = $GLOBALS['token'];
$about_participant_form_url = $GLOBALS['about_participant_form_url'];
$url = $about_participant_form_url."".$token;

return "
Liebe Stammesleitung vom Stamm $groupname, <br>
$participant_firstname $participant_lastname aus deinem Stamm hat sich soeben für 
den Kurs $participant_course beworben.
<br>
Damit die Bewerbung an das Kursteam weitergegeben werden kann, brauchen wir noch eine paar Informationen von dir.
Bitte fülle dazu folgendes Formular aus:<br>
<a href='$url'>$url</a>
<br>
<br>
Vielen Dank und Gut Pfad<br>
Joschko
";