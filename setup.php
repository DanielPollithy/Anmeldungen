<?php

// This file shall only be executable from the bash
if (!$argv[1] || !($argv[1] == "RUN")) {
	exit();
}

// TODO: MAKE HEALTH CHECK! (do all necessary functions work, e.g. shell_exec)

include("db.php");

error_log("Run setup.php");

setup_table_participants();
setup_table_group();
setup_table_tokens();

batch_add_group();



?>