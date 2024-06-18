<?php
require_once 'config.php';

$id = $_GET['id'];

// Supprimer la relation dans la table quizs_questions
$sql = "DELETE FROM questions WHERE id=?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: question_manage.php");
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->error;
    }
} else {
    echo "Erreur lors de la préparation de la requête : " . $conn->error;
}