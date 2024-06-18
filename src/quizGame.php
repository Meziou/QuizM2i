<?php

ob_start();
require_once 'config.php';

?>



<?php
$content = ob_get_clean();
require 'layout.php';
?>