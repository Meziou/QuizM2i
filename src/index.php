<?php
ob_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO quizs (name) VALUES (?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $stmt = $conn->prepare("UPDATE quizs SET name = ? WHERE id = ?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM quizs WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
$sql = "SELECT * FROM quizs";
$result = $conn->query($sql);
$quizs = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateModalLabel">Modifier un quiz</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateQuizForm" method="POST">
                    <input type="hidden" name="id" id="updateQuizId">
                    <input type="hidden" name="action" value="update">
                    <div class="mb-3">
                        <label for="updateQuizName" class="form-label">Nom du quiz</label>
                        <input type="text" class="form-control" name="name" id="updateQuizName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="my-5 d-flex justify-content-end">
    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addModal">
        Ajouter un quiz
    </button>
    <a class="btn btn-primary" href="question_manage.php">Gérer les questions</a>
</div>


<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="addModalLabel">Ajouter un quiz</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="quizName" class="form-label">Nom du quiz</label>
                        <input type="text" class="form-control" name="name" id="quizName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($quizs as $quiz) : ?>
        <div class="col-md-4 mb-4">
            <a class="card-link" href="quiz.php?id=<?= $quiz['id'] ?>" style="text-decoration: none;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center mb-3"><?= $quiz['name'] ?></h5>
                        <button type="button" class="btn btn-warning edit-button" data-id="<?= $quiz['id'] ?>" data-name="<?= htmlspecialchars($quiz['name']) ?>" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="setUpdateFormData(<?= $quiz['id'] ?>, '<?= htmlspecialchars($quiz['name']) ?>')">Modifier</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $quiz['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                    <img src="https://picsum.photos/1000/500?/<?php echo $quiz['name']; ?>" class=" card-img-top" alt="...">
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-button');
        const cardLinks = document.querySelectorAll('.card-link');

        editButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();  // Empêche l'action par défaut du clic sur le lien
                event.stopPropagation();  // Empêche la propagation de l'événement de clic
                const quizId = event.target.dataset.id;
                const quizName = event.target.dataset.name;

                document.getElementById('updateQuizId').value = quizId;
                document.getElementById('updateQuizName').value = quizName;
            });
        });

        cardLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                if (event.target.classList.contains('edit-button')) {
                    event.preventDefault();
                }
            });
        });
    });

    function setUpdateFormData(id, name) {
        document.getElementById('updateQuizId').value = id;
        document.getElementById('updateQuizName').value = name;
    }
</script>

<?php
$title = 'Liste des quiz';
$content = ob_get_clean();
require 'layout.php';