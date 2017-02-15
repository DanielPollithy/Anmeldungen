<?php


include("credentials.php");
include("helpers.php");

function get_connection() {
	if (! array_key_exists("connection", $GLOBALS) ) {
		$GLOBALS['connection'] = new mysqli($GLOBALS['db_servername'], $GLOBALS['db_username'], $GLOBALS['db_password']);
		if ($GLOBALS['connection']->connect_error) {
			error_log("DB connection failed");
			die("Connection failed: " . $GLOBALS['connection']->connect_error);
		}
	$GLOBALS['connection']->select_db($GLOBALS['db_dbname']);		
	}
	return $GLOBALS['connection'];
}


function setup_table_participants() {
	$conn = get_connection();
	$sql = "CREATE TABLE Participants (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(50) NOT NULL,
	lastname VARCHAR(50) NOT NULL,
	nickname VARCHAR(50),
	birthdate VARCHAR(50),
	zip VARCHAR(20),
	city VARCHAR(100),
	groupname VARCHAR(50),
	street VARCHAR(200),
	streetnumber VARCHAR(20),
	cellphone VARCHAR(100),
	email VARCHAR(100),
	information VARCHAR(100),
	train_benefit VARCHAR(50),
	closest_train_station VARCHAR(200),
	course VARCHAR(50),
	grundkurs_additional VARCHAR(30),
	
	foto_publications_website BOOL,
	foto_publications_socialmedia BOOL,
	foto_publications_print_and_info BOOL,
	
	application_date TIMESTAMP,
	firm_date_participant VARCHAR(100),
	
	member_since_year INTEGER,
	has_kubalibre BOOL,
	attended_courses VARCHAR(1000),
	my_function VARCHAR(1000),
	justification_for_my_function VARCHAR(1000),
	special_about_my_group VARCHAR(1000),
	biggest_challenge_in_my_group VARCHAR(1000),
	my_expectations VARCHAR(2000),
	want_to_learn VARCHAR(1000),
	
	group_leader_access_token VARCHAR(200),
	
	group_leader_about_function VARCHAR(1000),
	group_leader_about_expectations VARCHAR(1000),
	group_leader_about_group_situation VARCHAR(1000),
	
	meuten_number VARCHAR(10),
	meuten_participants_each VARCHAR(10),
	meuten_annotations VARCHAR(100),
	
	sippen_number VARCHAR(10),
	sippen_participants_each VARCHAR(10),
	sippen_annotations VARCHAR(100),
	
	runden_number VARCHAR(10),
	runden_participants_each VARCHAR(10),
	runden_annotations VARCHAR(100),
	
	misc_number VARCHAR(10),
	misc_participants_each VARCHAR(10),
	misc_annotations VARCHAR(100),
	
	total_number VARCHAR(10),
	total_participants_each VARCHAR(10),
	total_annotations VARCHAR(100),
	
	fulfilles_profile BOOL,
	group_provides_opportunities BOOL,
	
	group_leader_name VARCHAR(100),
	group_leader_email VARCHAR(100),
	group_leader_cellphone VARCHAR(100),	
	group_leader_firm_date DATE,
	
	handwritten_firm BOOL,
	handwritten_firm_date DATE
	
	
	)";
	if ($conn->query($sql) === TRUE) {
		echo "Table Participants created successfully";
		error_log("Table Participants created successfully");
	} else {
		echo "Error creating table: " . $conn->error;
		error_log("Error creating table: " . $conn->error);
	}
}

function setup_table_group() {
	$conn = get_connection();
	$sql = "CREATE TABLE Groups (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(80) NOT NULL,
email VARCHAR(30) NOT NULL
	)";
	if ($conn->query($sql) === TRUE) {
		echo "Table Groups created successfully";
		error_log("Table Groups created successfully");
	} else {
		echo "Error creating table: " . $conn->error;
		error_log("Error creating table: " . $conn->error);
	}
}


function setup_table_tokens() {
	$conn = get_connection();
	$sql = "CREATE TABLE Tokens (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
token VARCHAR(500) NOT NULL,
created DATE NOT NULL
	)";
	if ($conn->query($sql) === TRUE) {
		echo "Table Tokens created successfully";
		error_log("Table Tokens created successfully");
	} else {
		echo "Error creating table: " . $conn->error;
		error_log("Error creating table: " . $conn->error);
	}
}


function grab_dump($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

// TODO: Evitate code injection
function add_participant($firstname, $lastname, $nickname, $birthdate, $zip, $city, $groupname, $street, $streetnumber,
	$cellphone, $email, $information, $train_benefit, $closest_train_station, $course, $grundkurs_additional,	
	$foto_publications_website, $foto_publications_socialmedia, $foto_publications_print_and_info,	
	$member_since_year, $has_kubalibre, $attended_courses,
	$my_function, $justification_for_my_function, $special_about_my_group, $biggest_challenge_in_my_group,
	$my_expectations, $want_to_learn, $token)  {	
		
	$conn = get_connection();
	$stmt = $conn->prepare("INSERT INTO Participants 
	(firstname, lastname, nickname, birthdate, zip, city, groupname, street, streetnumber,
	cellphone, email, information, train_benefit, closest_train_station, course, grundkurs_additional,	
	foto_publications_website, foto_publications_socialmedia, foto_publications_print_and_info,	
	application_date, member_since_year, has_kubalibre, attended_courses,
	my_function, justification_for_my_function, special_about_my_group, biggest_challenge_in_my_group,
	my_expectations, want_to_learn, group_leader_access_token)
	VALUES 
	(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
	);
	
	if (!$stmt) {
		error_log("Error while adding participant");
		error_log(grab_dump(func_get_args()));
		echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
		error_log("Prepare failed: (" . $conn->errno . ") " . $conn->error);
	}
	$stmt->bind_param("sssssssssssssssssssssssssssss", $firstname, $lastname, $nickname, $birthdate, $zip, $city, 
			$groupname, $street, $streetnumber, $cellphone, $email, $information, $train_benefit, $closest_train_station, 
			$course, $grundkurs_additional,	$foto_publications_website, $foto_publications_socialmedia, 
			$foto_publications_print_and_info, $member_since_year, $has_kubalibre, $attended_courses, $my_function, 
			$justification_for_my_function, $special_about_my_group, $biggest_challenge_in_my_group,
			$my_expectations, $want_to_learn, $token
	);		
	$stmt->execute();
	if ($conn->error) {
		error_log("Error while adding participant");
		error_log(grab_dump(func_get_args()));
	}
	$stmt->close();
}

function add_group($name, $email) {
	$conn = get_connection();
	$stmt = $conn->prepare("INSERT INTO Groups (name, email) VALUES (?, ?)");
	$stmt->bind_param("ss", $name, $email);
	$stmt->execute();
	$stmt->close();
	error_log("Successfully added group");
}

function batch_add_group() {
	$groups = array(
		"Barrakuda" => "pollithy.daniel@gmail.com",
		"Pegasus" => "pollithy.daniel@gmail.com",
		"Sonstiges" => "pollithy.daniel@gmail.com"
	);
	foreach ($groups as $group => $email) {
		add_group($group, $email);
	}
}

function get_email_by_group($name) {
	$conn = get_connection();
	$stmt = $conn->prepare("SELECT email FROM Groups WHERE name=? LIMIT 1");
	$stmt->bind_param("s", $name);
	$result = $stmt->execute();
	$stmt->bind_result($email);
	$stmt->fetch();
	$stmt->close();
	return $email;
}

function get_participant_by_token($token) {
	$conn = get_connection();
	$stmt = $conn->prepare(
	"SELECT firstname, lastname, nickname, groupname, course, birthdate, zip, city FROM Participants 
	WHERE group_leader_access_token = ?;");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($firstname, $lastname, $nickname, $groupname, $course, $birthdate, $zip, $city);
	$stmt->fetch();	
	if ($stmt->num_rows <> 1) {
		error_log("There was no participant with token: $token");
		echo "Token error";
		exit();
	}	
	$stmt->close();
	return [$firstname, $lastname, $nickname, $groupname, $course, $birthdate, $zip, $city];
}

function remove_participant_token($token) {
	$conn = get_connection();
	$stmt = $conn->prepare("UPDATE Participants SET group_leader_access_token=NULL WHERE group_leader_access_token = ?;");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->close();
}

function add_info_about_participant(
		$group_leader_about_function,
		$group_leader_about_expectations,
		$group_leader_about_group_situation,	
		$meuten_number,
		$meuten_participants_each,
		$meuten_annotations,	
		$sippen_number,
		$sippen_participants_each,
		$sippen_annotations,	
		$runden_number,
		$runden_participants_each,
		$runden_annotations,	
		$misc_number,
		$misc_participants_each,
		$misc_annotations,	
		$total_number,
		$total_participants_each,
		$total_annotations,	
		$fulfilles_profile,
		$group_provides_opportunities,	
		$group_leader_name,
		$group_leader_email,
		$group_leader_cellphone,
		$group_leader_access_token) {
			
	
	$conn = get_connection();
	$stmt = $conn->prepare("UPDATE Participants SET 
	`group_leader_about_function` = ?,
	`group_leader_about_expectations` = ?,
	`group_leader_about_group_situation` = ?,	
	`meuten_number` = ?,
	`meuten_participants_each` = ?,
	`meuten_annotations` = ?,	
	`sippen_number` = ?,
	`sippen_participants_each` = ?,
	`sippen_annotations` = ?,	
	`runden_number` = ?,
	`runden_participants_each` = ?,
	`runden_annotations` = ?,	
	`misc_number` = ?,
	`misc_participants_each` = ?,
	`misc_annotations` = ?,	
	`total_number` = ?,
	`total_participants_each` = ?,
	`total_annotations` = ?,	
	`fulfilles_profile` = ?,
	`group_provides_opportunities` = ?,	
	`group_leader_name` = ?,
	`group_leader_email` = ?,
	`group_leader_cellphone` = ?,	
	`group_leader_firm_date` = NOW() 
	WHERE `group_leader_access_token` = ?;
	");
	if (!$stmt) {
		error_log("Error while adding info about participant");
		error_log(grab_dump(func_get_args()));
		echo "".$conn->error;
		error_log("SQL: ".$conn->error);		
	}	
	$fulfilles_profile = intval($fulfilles_profile);
	$group_provides_opportunities = intval($group_provides_opportunities);
	$group_leader_access_token = trim($group_leader_access_token);	
	
	$stmt->bind_param("ssssssssssssssssssiissss", 
		$group_leader_about_function,
		$group_leader_about_expectations,
		$group_leader_about_group_situation,	
		$meuten_number,
		$meuten_participants_each,
		$meuten_annotations,	
		$sippen_number,
		$sippen_participants_each,
		$sippen_annotations,	
		$runden_number,
		$runden_participants_each,
		$runden_annotations,	
		$misc_number,
		$misc_participants_each,
		$misc_annotations,	
		$total_number,
		$total_participants_each,
		$total_annotations,	
		$fulfilles_profile,
		$group_provides_opportunities,	
		$group_leader_name,
		$group_leader_email,
		$group_leader_cellphone,	
		$group_leader_access_token
	);

	$result = $stmt->execute();
	
	if ($conn->error) {
		error_log("Error while adding info about participant");
		error_log(grab_dump(func_get_args()));
		echo "".$conn->error;
		error_log("SQL: ".$conn->error);		
	}	
	
	$stmt->close();
	
	// make participant uneditable
	remove_participant_token($group_leader_access_token);
}

function get_participants_for_administration() {
	$conn = get_connection();
	$result = $conn->query("SELECT id, firstname, lastname, groupname, email, group_leader_access_token, firm_date_participant  
	FROM Participants ORDER BY id DESC;");
	$rows = [];
	while($row = $result->fetch_array(MYSQLI_NUM)) {
		$rows[] = $row;
	}
	$result->close();
	return $rows;
}

function get_list_of_groups() {
	$conn = get_connection();
	$result = $conn->query("SELECT name FROM Groups;");
	$rows = [];
	while($row = $result->fetch_array(MYSQLI_NUM)) {
		$rows[] = $row;
	}
	$result->close();
	return $rows;
}

function reveived_firmed_application($id, $date) {
	$conn = get_connection();
	$stmt = $conn->prepare("UPDATE Participants SET firm_date_participant = ? WHERE id = ?;");
	if (!$stmt) {
		error_log("Error while adding firm_date_participant");
		error_log(grab_dump(func_get_args()));
	}
	$stmt->bind_param("ss", $date, $id);
	$result = $stmt->execute();
	if ($conn->error) {
		error_log("Error while adding info about participant");
		error_log(grab_dump(func_get_args()));
		echo "".$conn->error;
		error_log("SQL: ".$conn->error);		
	}	
	$stmt->close();
}


function get_access_secret() {
	$token = get_secret();
	$conn = get_connection();
	$stmt = $conn->prepare("INSERT INTO Tokens (token, created) VALUES (?, NOW())");
	$stmt->bind_param("s", $token);
	$stmt->execute();
	$stmt->close();
	return $token;
}

// TODO: invalidate tokens after time
function validate_access_secret($token) {
	$conn = get_connection();
	$stmt = $conn->prepare(
	"SELECT token, created FROM Tokens	WHERE token = ?;");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($token_from_table, $created);
	$stmt->fetch();	
	if ($stmt->num_rows <> 1) {
		error_log("There was no access_token: $token");
		echo "Token error";
		exit();
	}		
	$stmt->close();
	
	//DELETE token from table
	$stmt = $conn->prepare("DELETE FROM Tokens WHERE token = ?;");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->close();
	
	return true;
}


function get_reminder_list($groupname) {
	$sql = 'SELECT Groups.name, Groups.email, Participants.firstname, Participants.lastname, Participants.firm_date_participant, Participants.group_leader_access_token 
			FROM Groups, Participants 
			WHERE Groups.name = Participants.groupname AND (Participants.firm_date_participant IS NULL OR Participants.group_leader_access_token IS NOT NULL)';
	$conn = get_connection();
	$result = $conn->query($sql);
	$rows = array();
	while($row = $result->fetch_array(MYSQLI_NUM)) {
		if (!array_key_exists($row[0], $rows)) {
			$rows[$row[0]] = [];
		}
		$rows[$row[0]][] = $row;
	}
	$result->close();
	return $rows;
}

