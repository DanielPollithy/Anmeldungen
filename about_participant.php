<?php 

include("db.php");

if (!array_key_exists("token", $_GET)) {
	echo "Where is your token?";
	error_log("Access about_participant.php without token");
	exit();
}

$participant_array = get_participant_by_token($_GET['token']);
$firstname = $participant_array[0];
$lastname = $participant_array[1];
$nickname = $participant_array[2];
$groupname = $participant_array[3];
$course = $participant_array[4];

?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StaFü-Formular</title>
	<link rel="stylesheet" href="CSS/form.css">
  </head>
  <body>
	<form action="submit_about_participant.php" method="post">
		<label for="firstname">Vorname</label>
		<input type="text" name="firstname" value="<? echo $firstname ?>" readonly>
		<br>
		
		<label for="lastname">Nachname</label>
		<input type="text" name="lastname" value="<? echo $lastname ?>" readonly>
		<br>
		
		<label for="nickname">Pfadiname</label>
		<input type="text" name="nickname" value="<? echo $nickname ?>" readonly>
		<br>
		
		<label for="groupname">Stamm</label>
		<input type="text" name="groupname" value="<? echo $groupname ?>" readonly>
		<br>
		
		<label for="course">Kurs</label>
		<input type="text" name="course" value="<? echo $course ?>" readonly>
		<br>
		
		<label for="group_leader_about_function">Welche Aufgabe soll eure Teilnehmerin/euer Teilnehmer im Stamm übernehmen/weiterführen?</label>
		<textarea name="group_leader_about_function" rows="4" cols="30"></textarea>
		<br>
		
		<label for="group_leader_about_expectations">Welche Erwartungen habt ihr vom Besuch eurer Teilnehmerin/eures Teilnehmers am Kurs?</label>
		<textarea name="group_leader_about_expectations" rows="4" cols="30"></textarea>
		
		<label for="group_leader_about_group_situation"> Beschreibe kurz die Gruppensituation aus der eure Teilnehmerin/euer Teilnehmer kommt. Sollte er/sie Gruppenleiter/innenfunktion haben, beschreibe bitte das Team (z.B. die Stufenführung) in der er/sie mitarbeitet. </label>
		<textarea name="group_leader_about_group_situation" rows="4" cols="30"></textarea>
		
		<label for="meuten_number">Anzahl Meuten</label>
		<input type="text" name="meuten_number">
		<br>
		
		<label for="meuten_participants_each">Personen je</label>
		<input type="text" name="meuten_participants_each">
		
		<label for="meuten_annotations">Anmerkung</label>
		<input type="text" name="meuten_annotations">
		<br>
		
		<label for="sippen_number">Anzahl Sippen</label>
		<input type="text" name="sippen_number">
		
		<label for="sippen_participants_each">Personen je</label>
		<input type="text" name="sippen_participants_each">
		
		<label for="sippen_annotations">Anmerkung</label>
		<input type="text" name="sippen_annotations">
		<br>
		
		<label for="runden_number">Anzahl Runden</label>
		<input type="text" name="runden_number">
		
		<label for="runden_participants_each">Personen je</label>
		<input type="text" name="runden_participants_each">
		
		<label for="runden_annotations">Anmerkung</label>
		<input type="text" name="runden_annotations">
		<br>
		
		<label for="misc_number">Anzahl Sonstiges</label>
		<input type="text" name="misc_number">
		
		<label for="misc_participants_each">Personen je</label>
		<input type="text" name="misc_participants_each">
		
		<label for="misc_annotations">Anmerkung</label>
		<input type="text" name="misc_annotations">
		<br>
		
		<label for="total_number">Gesamt Anzahl</label>
		<input type="text" name="total_number">
		
		<label for="total_participants_each">Personen je</label>
		<input type="text" name="total_participants_each">
		
		<label for="total_annotations">Anmerkung</label>
		<input type="text" name="total_annotations">
		<br>
		
		<label for="fulfilles_profile">Der/die Teilnehmende erfüllt das in der Bundesausbildungskonzeption genannte Profil zur Teilnahme</label>
		<input type="checkbox" name="fulfilles_profile" value="False">
		<br>
		
		<label for="group_provides_opportunities">Der Stamm bietet dem/der Teilnehmenden nach dem Kurs Raum und Möglichkeit, die erworbenen Kenntnisse praktisch umzusetzen.</label>
		<input type="checkbox" name="group_provides_opportunities" value="False">
		<br>
		
		<label for="group_leader_name">Name der/des Stammesführers/in</label>
		<input type="text" name="group_leader_name">
		<br>
		
		<label for="group_leader_email">E-Mail</label>
		<input type="email" name="group_leader_email">
		<br>
		
		<label for="group_leader_cellphone">Handy oder Telefon</label>
		<input type="text" name="group_leader_cellphone">
		<br>
		
		<input type="hidden" name="group_leader_access_token" value=" <?php echo $_GET['token'];?>">
		<input type="submit" value="Abschicken">
	</form>
  </body>
</html>