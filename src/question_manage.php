<?php
ob_start();
require_once 'config.php';

//Récupérer toutes les questions et leur réponse
$sql2 = "SELECT name, response, id, correctAnswer
    FROM questions";

$result = $conn->query($sql2);
$questions = $result->fetch_all(MYSQLI_ASSOC);
$idQuestion = $result->fetch_assoc();
?>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuestionToDBModal">
        Ajouter une question
    </button>
    <div>
        <?php foreach ($questions as $question): ?>
            <div class="crossParent border border-3 rounded my-4 p-2">
                <a class="deleteCross" href="delete_question_onDB.php?id=<?= $question['id']?>">❌</a>
                <form action="question_update_fromAll.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $question['id']; ?>">
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
    <div class="modal fade" id="addQuestionToDBModal" tabindex="-1" role="dialog" aria-labelledby="addQuestionToDBModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="question_addtoDB.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addQuestionToDBModalLabel">Ajouter une question</h5>
                    </div>
                    <div class="modal-body">
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
$title = "Gérer toutes les questions";
$content = ob_get_clean();
require 'layout.php';