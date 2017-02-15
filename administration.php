<?php

include("db.php");

$participants = get_participants_for_administration();

$access_secret = get_access_secret();

?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gabis Administration</title>
  </head>
  <body>
	<form action="submit_admin.php" method="POST">
		<table style="width:100%">
		  <tr>
			<th>id</th>
			<th>Vorname</th> 
			<th>Nachname</th>
			<th>Stamm</th>
			<th>E-Mail</th>
			<th>Stafü ausgefüllt</th>
			<th>Anmeldung liegt vor</th>
			<th>Datum der Unterschrift</th>
		  </tr>
		  <?php	  
		  foreach ($participants as $participant) {
				echo "<tr>\n";			  
				foreach (array_values($participant) as $i => $value) {
				  if ($i == 5) { // group_access_token
					  if (is_null($value)) {
						  echo "<td>Ja</td>\n";	
					  } else {
						  echo "<td>Nein</td>\n";
					  }
				  } else if ($i == 6) {
					  if (is_null($value)) {
						  $id = $participant[0];						  
						  echo "<td><input type='checkbox' name='ids[]' value='$id'> </td>\n";
						  echo "<td><input type='date' name='date-$id'> </td>\n";						  
					  } else  {
						  echo "<td>(eingetragen)</td>\n";
						  echo "<td>$value</td>\n";	
					  }
				  } else {
					echo "<td>$value</td>\n";
				  }
				}
				echo "</tr>\n";
			  }  	  
		  ?> 
		</table>
		<input type="hidden" name="access_secret" value="<?php echo $access_secret; ?>">
		<input type="submit" value="Speichern">
	</form>
  </body>
 </html>