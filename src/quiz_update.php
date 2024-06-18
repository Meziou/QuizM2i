<?php
global $conn;
ob_start();
require_once 'config.php';

$id = $_GET['id'];

// Récupérer les informations du quiz
$sql = "SELECT name FROM quizs WHERE id = $id";
$result = $conn->query($sql);
$quiz = $result->fetch_assoc();

// Récupérer les questions et les réponses du quiz choisi
$sql2 = "SELECT q.name, q.response, q.id, q.correctAnswer
    FROM questions q
    INNER JOIN quizs_questions qq ON q.id = qq.id_questions
    WHERE qq.id_quizs = $id";

$result = $conn->query($sql2);
$questions = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="text-primary text-center">Quiz <?php echo $quiz['name'] ?></h2>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        Ajouter une question
    </button>
<div>
    <?php foreach ($questions as $question): ?>
        <div class="crossParent border border-3 rounded my-4 p-2">
            <a class="deleteCross" href="delete_question.php?id=<?= $question['id']?>&quiz_id=<?= $id ?>">❌</a>
            <form action="question_update.php" method="post">
                <input type="hidden" name="quiz_id" value="<?= $id ?>">
                <input type="hidden" name="question_id" value="<?= $question['id'] ?>">
                <textarea name="name"  class="form-control my-3" required><?php echo $question['name']?></textarea>
                <textarea name="response"  class="form-control my-3" required><?php echo $question['response']?></textarea>
                <label for="correctAnswer" class="mt-1">Réponse (1,2,3,4) :</label>
                <input type="number" name="correctAnswer" class="form-control mb-4" value="<?php echo $question['correctAnswer']?>" required>
                <button class="btn btn-success" type="submit">Enregistrer</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="question_add.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionModalLabel">Ajouter une question</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="quiz_id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="name">Question</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="response">Réponses</label>
                        <textarea class="form-control" name="response" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="correctAnswer">Bonne réponse (index)</label>
                        <input type="number" class="form-control" name="correctAnswer" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
$title = "Modifier un quiz";
$content = ob_get_clean();
require 'layout.php';