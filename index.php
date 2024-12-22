<?php

require_once "config/database.php";

if (isset($_GET["action"]) && !empty($_GET["action"])) {
    $action = $_GET["action"];
    include_once "actions/" . $action . ".php";
}

if (isset($_GET["page"]) && !empty($_GET["page"])) {
    $page = $_GET["page"];
    include_once "views/" . $page . ".php";
} 

header('location:views/signup.php');
?>