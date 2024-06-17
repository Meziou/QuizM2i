<?php
global $conn;
ob_start();
require_once 'config.php';

$id = $_GET['id'];

// Récupérer les informations du quiz
$sql = "SELECT name FROM quizs WHERE id = $id";
$result = $conn->query($sql);
$quiz = $result->fetch_assoc();

// Récupérer les questions du quiz choisis
$sql2 = "SELECT q.name
    FROM questions q
    INNER JOIN quizs_questions qq ON q.id = qq.id_questions
    WHERE qq.id_quizs = $id";

$result = $conn->query($sql2);
$questions = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="text-primary">Quiz <?php echo $quiz['name'] ?></h2>

    <p>Questions :</p>
<?php foreach ($questions as $question): ?>
    <p>
        <?php echo $question['name']?>
    </p>
<?php endforeach; ?>


<?php
$title = "Quiz";
$content = ob_get_clean();
require 'layout.php';