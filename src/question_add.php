<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $name = $_POST['name'];
    $response = $_POST['response'];
    $correctAnswer = $_POST['correctAnswer'];

    // Insérer la nouvelle question dans la table questions
    $sql = "INSERT INTO questions (name, response, correctAnswer) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssi", $name, $response, $correctAnswer);
        if ($stmt->execute()) {
            // Récupérer l'id de la question nouvellement insérée
            $question_id = $stmt->insert_id;

            // Insérer la relation dans la table quizs_questions
            $sql_relation = "INSERT INTO quizs_questions (id_quizs, id_questions) VALUES (?, ?)";
            $stmt_relation = $conn->prepare($sql_relation);
            if ($stmt_relation) {
                $stmt_relation->bind_param("ii", $quiz_id, $question_id);
                if ($stmt_relation->execute()) {
                    header("Location: quiz_update.php?id=$quiz_id");
                } else {
                    echo "Erreur : " . $sql_relation . "<br>" . $stmt_relation->error;
                }
            } else {
                echo "Erreur lors de la préparation de la requête : " . $conn->error;
            }
        } else {
            echo "Erreur : " . $sql . "<br>" . $stmt->error;
        }
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
} else {
    echo "Méthode non autorisée.";
}