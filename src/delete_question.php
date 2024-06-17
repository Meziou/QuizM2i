<?php
require_once 'config.php';

$id = $_GET['id'];
$quiz_id = $_GET['quiz_id'];

// Supprimer la relation dans la table quizs_questions
$sql = "DELETE FROM quizs_questions WHERE id_questions=? AND id_quizs=?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ii", $id, $quiz_id);
    if ($stmt->execute()) {
        header("Location: quiz_update.php?id=$quiz_id");
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->error;
    }
} else {
    echo "Erreur lors de la préparation de la requête : " . $conn->error;
}