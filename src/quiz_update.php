<?php
global $conn;
ob_start();
require_once 'config.php';

$id = intval($_GET['id']);

// Récupérer les informations du quiz
$sql = "SELECT name FROM quizs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();


// Récupérer les questions et les réponses du quiz choisi
$sql2 = "SELECT q.name, q.response, q.id, q.correctAnswer
    FROM questions q
    INNER JOIN quizs_questions qq ON q.id = qq.id_questions
    WHERE qq.id_quizs = ?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $id);
$stmt2->execute();
$result2 = $stmt2->get_result();
$questions = $result2->fetch_all(MYSQLI_ASSOC);

// Afficher les questions qui ne sont pas dans ce quiz
$query = "SELECT q.id, q.name FROM questions q
            WHERE q.id 
            NOT IN (SELECT id_questions
                    FROM quizs_questions 
                    WHERE id_quizs = ?)";
$stmt3 = $conn->prepare($query);
$stmt3->bind_param('i', $id);
$stmt3->execute();
$result3 = $stmt3->get_result();
$available_questions = $result3->fetch_all(MYSQLI_ASSOC);

if (isset($_POST['add_question'])) {
    $id_questions = intval($_POST['id_question']);
    $query = "INSERT INTO quizs_questions (id_quizs, id_questions) VALUES (?, ?)";
    $stmt4 = $conn->prepare($query);
    $stmt4->bind_param('ii', $id, $id_questions);
    $stmt4->execute();
    header("Location: quiz_update.php?id=$id");
    exit;
}
?>

<h2 class="text-primary text-center mt-4"><?php echo htmlspecialchars($quiz['name']); ?></h2>

<form method="post" action="quiz_update.php?id=<?php echo $id; ?>" class="my-3">

    <select name="id_question" class="form-select">
        <option>--Choisissez une question à ajouter au quiz</option>
        <?php foreach ($available_questions as $question) { ?>
            <option value="<?php echo htmlspecialchars($question['id']); ?>"><?php echo htmlspecialchars($question['name']); ?></option>
        <?php } ?>
    </select>
    <button type="submit" name="add_question" class="btn btn-primary mt-3">Ajouter la question</button>
</form>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionModal">
        Créer une question
    </button>

<div>
    <?php foreach ($questions as $question): ?>
        <div class="crossParent border border-3 rounded my-4 p-2">
            <a class="deleteCross" href="delete_question.php?id=<?= htmlspecialchars($question['id']) ?>&quiz_id=<?= $id ?>">❌</a>
            <form action="question_update.php" method="post">
                <input type="hidden" name="quiz_id" value="<?= $id ?>">
                <input type="hidden" name="question_id" value="<?= htmlspecialchars($question['id']) ?>">
                <textarea name="name" class="form-control my-3" required><?php echo htmlspecialchars($question['name']); ?></textarea>
                <textarea name="response" class="form-control my-3" required><?php echo htmlspecialchars($question['response']); ?></textarea>
                <label for="correctAnswer" class="mt-1">Réponse (1,2,3,4) :</label>
                <input type="number" name="correctAnswer" class="form-control mb-4" value="<?php echo htmlspecialchars($question['correctAnswer']); ?>" required>
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