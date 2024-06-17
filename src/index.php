<?php
ob_start();
require_once 'config.php';


$title ='Quiz';
$content = ob_get_clean();
require 'layout.php';
