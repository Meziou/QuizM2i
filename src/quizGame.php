<?php
require_once 'config.php';

header('Content-Type: application/json');


$id = $_GET['id'];

$sql1 = "SELECT name FROM quizs";
$result1 = $conn->query($sql1);
$quizName = $result1->fetch_assoc();


$sql2 = "SELECT q.* FROM questions q 
         INNER JOIN quizs_questions qq 
         ON q.id = qq.id_questions 
         WHERE qq.id_quizs= $id";
$stmt = $conn->prepare($sql2);

$stmt->execute();
$result = $stmt->get_result();
if ($result) {
    $data = $result->fetch_all();
} else {
		http_response_code(404);
		$data = ['error' => 'No data found'];
}

echo json_encode($data);

?>
