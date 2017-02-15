<?php

include("db.php");

$groups = get_list_of_groups();

?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formular-Titel</title>
	<link rel="stylesheet" href="CSS/form.css">
  </head>
  <body>
	<form action="submit_participant.php" method="post">
		<label for="firstname">Vorname</label>
		<input type="text" name="firstname">
		<br>
		
		<label for="lastname">Nachname</label>
		<input type="text" name="lastname">
		<br>
		
		<label for="nickname">Pfadiname</label>
		<input type="text" name="nickname">
		<br>
		
		<label for="groupname">Stamm</label>
		<select name="groupname">
			<?php 
			foreach ($groups as $group) {
				echo "<option value='{$group[0]}'>{$group[0]}</option>";
				echo '\n';
			}
			?>
		</select>
		<br>
		
		<label for="birthdate">Geburtstag</label>
		<input type="date" name="birthdate">
		<br>
		
		<label for="street">Strasse</label>
		<input type="text" name="street">
		<br>
		
		<label for="streetnumber">Hausnummer</label>
		<input type="text" name="streetnumber">
		<br>
		
		<label for="zip">Postleitzahl</label>
		<input type="text" name="zip">
		<br>
		
		<label for="city">Ort</label>
		<input type="text" name="city">
		<br>	
		
		
		
		
		<label for="cellphone">Handy oder Telefon</label>
		<input type="text" name="cellphone">
		<br>
		
		<label for="email">E-Mail</label>
		<input type="email" name="email">
		<br>
		
		<label for="information">Informationen (z.B. Vegetarisch, allergisch gegen etwas, Medikamente)</label>
		<input type="text" name="information">
		<br>
		
		<label for="train_benefit">Zugvergünstigungen</label>
		<input type="text" name="train_benefit">
		<br>
		
		<label for="closest_train_station">Näheste Zugstation</label>
		<input type="text" name="closest_train_station">
		<br>
		
		<label for="course">Kurs</label>
		<select name="course">
		  <option value="Kalu">Kalu</option>
		  <option value="BooM">BooM</option>
		  <option value="KfM">KfM</option>
		  <option value="KfS">KfS</option>
		  <option value="Tilop">Tilop</option>
		  <option value="Start">Start</option>
		  <option value="GK_Woelfi">Grundkurs Süd - Wölflingsstufe</option>
		  <option value="GK_Pfadi">Grundkurs Süd - Pfadistufe</option>
		  <option value="GK_Runde">Grundkurs Süd - R/R-Stufe</option>
		  <option value="GK_Stafue">Grundkurs Süd - Stammesführung</option>
		</select>
		<br>
		
		<label for="foto_publications_website">Fotos von mir auf Pfadi-Webseiten</label>
		<input type="checkbox" name="foto_publications_website" value="False">
		<br>
		
		<label for="foto_publications_socialmedia">Fotos von mir im Social Media</label>
		<input type="checkbox" name="foto_publications_socialmedia" value="False">
		<br>
		
		<label for="foto_publications_print_and_info">Fotos von mir in Print- und Infomaterialien</label>
		<input type="checkbox" name="foto_publications_print_and_info" value="False">
		<br>
		
		<label for="member_since_year">Im BdP seit (Jahr; für Kalu und Boom keine Mitgliedschaft nötig)</label>
		<input type="number" min="1900" max="2100" step="1" name="member_since_year">
		<br>
		
		<label for="has_kubalibre">Besitzt du ein Kubalibre?</label>
		<input type="checkbox" name="has_kubalibre" value="False">
		<br>
		
		<label for="attended_courses">Besuchte Kurse (mit Jahreszahl z.B. Kalu 2012; KfM 2013)</label>
		<input type="text" name="attended_courses">
		<br>
		
		<label for="my_function">Das ist mein Amt bzw. meine Funktion im Stamm.</label>
		<textarea name="my_function" rows="4" cols="30"></textarea>
		<br>
		
		<label for="justification_for_my_function">Darum habe ich mein Amt bzw. meine Funktion im Stamm inne.</label>
		<textarea name="justification_for_my_function" rows="4" cols="30"></textarea>	
		<br>		
		
		<label for="special_about_my_group">Das macht meinen Stamm besonders.</label>
		<textarea name="special_about_my_group" rows="4" cols="30"></textarea>
		<br>
		
		<label for="biggest_challenge_in_my_group">Das ist die derzeit größte Herausforderung für mich in meinem Stamm.</label>
		<textarea name="biggest_challenge_in_my_group" rows="4" cols="30"></textarea>
		<br>
		
		<label for="my_expectations">So lauten meine drei Erwartungen an den Kurs.</label>
		<textarea name="my_expectations" rows="4" cols="30"></textarea>
		<br>
		
		<label for="want_to_learn">Das möchte ich nach dem Kurs mit nach Hause nehmen.</label>
		<textarea name="want_to_learn" rows="4" cols="30"></textarea>
		<br>

		<input type="submit" value="Abschicken">
	</form>
  </body>
</html>