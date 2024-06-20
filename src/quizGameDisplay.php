<?php

require_once('config.php');
ob_start();

$id = $_GET['id'];
$sql = "SELECT name FROM quizs WHERE id = $id";
$result = $conn->query($sql);
$quiz = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div id="quiz">
        <div id="quiz-header">
            <div id="question-count"></div>
            <div id="timer">10</div>
        </div>
        <div id="questions"></div>
        <div id="result" class="result-message mt-5"></div>
        <div class="d-flex flex-column align-items-center">
            <div id="score" class="my-5 text-primary fs-1"></div>
            <button class="btn btn-lg btn-primary mt-3 px-3" style="display:block;" onclick="window.location.href='index.php'">Retourner à la liste des quiz</button>
            <button id="replay" class="btn btn-lg btn-primary mt-3 px-3" style="display:none;" onclick="window.location.href='quizGameDisplay.php?id=<?= $id ?>'"> Rejouer</button>
        </div>
    </div>
</div>

<script src="main.js" defer></script>
<?php
$title = 'Quiz '.$quiz['name'];
$content = ob_get_clean();
require 'layout.php';
?>


