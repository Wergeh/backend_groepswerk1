<?php

require_once "autoload.php";

$query="delete from record where recordID ={$_GET['recordID']}";
ExecuteSQL($query);
var_dump($query);
header("Location:../world_records.php");