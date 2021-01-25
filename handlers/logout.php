<?php
session_start();
session_destroy ();
unset ($_SESSION['user']);
header ('Location: /main.tpl.php');
