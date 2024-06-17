<?php
global $conn;
ob_start();
require_once 'config.php';

$id = $_GET['id'];

// Récupérer les informations du quiz
$sql = "SELECT name FROM quizs WHERE id = $id";
$result = $conn->query($sql);
$quiz = $result->fetch_assoc();

// Récupérer les questions et les réponses du quiz choisis
$sql2 = "SELECT q.name, q.response, q.id
    FROM questions q
    INNER JOIN quizs_questions qq ON q.id = qq.id_questions
    WHERE qq.id_quizs = $id";

$result = $conn->query($sql2);
$questions = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="text-primary text-center">Quiz <?php echo $quiz['name'] ?></h2>

    <p>Questions :</p>
<div>
    <?php foreach ($questions as $question): ?>
        <div class="border rounded my-2 p-2">
            <a href="delete_question.php?id=<?= $question['id']?>">❌</a>
            <p class="text-primary"><?php echo $question['name']?></p>
            <p><?php echo $question['response']?></p>
        </div>
    <?php endforeach; ?>
</div>

<?php
$title = "Modifier un quiz";
$content = ob_get_clean();
require 'layout.php';