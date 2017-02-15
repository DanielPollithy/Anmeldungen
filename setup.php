<?php

// TODO: Protect this from a web call

// TODO: MAKE HEALTH CHECK! (do all necessary functions work, e.g. shell_exec)

include("db.php");

setup_table_participants();
setup_table_group();
setup_table_tokens();

batch_add_group();



?>