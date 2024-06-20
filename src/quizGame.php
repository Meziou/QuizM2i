<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

header('Content-Type: application/json');

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'getQuestions') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $sql2 = "SELECT q.* FROM questions q 
                 INNER JOIN quizs_questions qq 
                 ON q.id = qq.id_questions 
                 WHERE qq.id_quizs = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2) {
            $questions = array();
            while ($row = $result2->fetch_assoc()) {
                $row['response'] = explode(',', $row['response']);
                $questions[] = $row;
            }
            echo json_encode($questions);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Aucune donnée trouvée']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID de quiz invalide']);
    }
} elseif ($action == 'checkAnswer') {
    $input = json_decode(file_get_contents('php://input'), true);
    $questionId = isset($input['questionId']) ? intval($input['questionId']) : 0;
    $selectedAnswer = isset($input['selectedAnswer']) ? intval($input['selectedAnswer']) : 0;

    if ($questionId > 0 && $selectedAnswer > 0) {
        $sql = "SELECT correctAnswer FROM questions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $questionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $correctAnswer = $result->fetch_assoc()['correctAnswer'];

        if ($selectedAnswer == $correctAnswer) {
            echo json_encode(['correct' => true]);
        } else {
            echo json_encode(['correct' => false]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Entrée invalide']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Action invalide']);
}