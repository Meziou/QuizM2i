<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $response = $_POST['response'];
    $correctAnswer = $_POST['correctAnswer'];

    // Insérer la nouvelle question dans la table questions
    $sql = "INSERT INTO questions (name, response, correctAnswer) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssi", $name, $response, $correctAnswer);
        if ($stmt->execute()) {
            header("Location: question_manage.php");
        } else {
            echo "Erreur : " . $sql . "<br>" . $stmt->error;
        }
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
} else {
    echo "Méthode non autorisée.";
}