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
                <h1 class="modal-title fs-5" id="updateModalLabel">Update quiz</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateQuizForm" method="POST">
                    <input type="hidden" name="id" id="updateQuizId">
                    <input type="hidden" name="action" value="update">
                    <div class="mb-3">
                        <label for="updateQuizName" class="form-label">Quiz Name</label>
                        <input type="text" class="form-control" name="name" id="updateQuizName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Add quiz
</button>
<a class="btn btn-primary" href="question_manage.php">Gérer les questions</a>


<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add quiz</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="quizName" class="form-label">Quiz Name</label>
                        <input type="text" class="form-control" name="name" id="quizName" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php foreach ($quizs as $quiz) : ?>
        <div class="col-md-4 mb-4">
            <a href="quiz.php?id=<?= $quiz['id'] ?>" style="text-decoration: none;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center"><?= $quiz['name'] ?></h5>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="setUpdateFormData(<?= $quiz['id'] ?>, '<?= htmlspecialchars($quiz['name']) ?>')">Edit</button>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $quiz['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    <img src="https://picsum.photos/1000/500?/<?php echo $quiz['name']; ?>" class="card-img-top" alt="...">
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>



<?php
$title = 'Quizs';
$content = ob_get_clean();
require 'layout.php';
?>