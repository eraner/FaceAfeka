<?php
session_start();

unset($_SESSION["loggedUser"]);
session_unset();

header("Location: ../index.php");