<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $question_id = $_POST['question_id'];
    $name = $_POST['name'];
    $response = $_POST['response'];
    $correctAnswer = $_POST['correctAnswer'];

    // Mettre à jour la question dans la table questions
    $sql = "UPDATE questions SET name=?, response=?, correctAnswer=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssii", $name, $response, $correctAnswer, $question_id);
        if ($stmt->execute()) {
            header("Location: quiz_update.php?id=$quiz_id");
        } else {
            echo "Erreur : " . $sql . "<br>" . $stmt->error;
        }
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
} else {
    echo "Méthode non autorisée.";
}