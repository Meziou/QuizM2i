<?php
global $conn;
ob_start();
require_once 'config.php';

$id = $_GET['id'];

// Récupérer les informations du quiz
$sql = "SELECT name FROM quizs WHERE id = $id";
$result = $conn->query($sql);
$quiz = $result->fetch_assoc();
?>

<div class="text-center d-flex flex-column justify-content-center align-items-center mt-5">
    <h2 class="text-primary"><?php echo $quiz['name'] ?></h2>
    <div class="mt-3">
        <a class="btn btn-secondary btn-lg mr-2" href="quiz_update.php?id=<?= $id ?>">Modifier le quiz</a>
        <a class="btn btn-success btn-lg">JOUER</a>
    </div>
</div>

<?php
$title = "Quiz ".$quiz['name'];
$content = ob_get_clean();
require 'layout.php';