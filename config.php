<?php

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$db_name = substr($url["path"], 1);
$db_host = $url["host"];
$user = $url["user"];
$password = $url["pass"];

$dsn = "mysql:dbname=".$db_name.";host=".$db_host;

?>
