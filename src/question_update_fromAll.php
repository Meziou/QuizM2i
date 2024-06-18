<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $id = $_POST['id']; // Modifier ici pour récupérer l'ID depuis POST
    $name = $_POST['name'];
    $response = $_POST['response'];
    $correctAnswer = $_POST['correctAnswer'];

    // Mettre à jour la question dans la base de donnée
    $sql = "UPDATE questions SET name=?, response=?, correctAnswer=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssii", $name, $response, $correctAnswer, $id);
        if ($stmt->execute()) {
            header("Location: question_manage.php"); // Modifier ici pour rediriger vers la page correcte
        } else {
            echo "Erreur : " . $sql . "<br>" . $stmt->error;
        }
    } else {
        echo "Erreur lors de la préparation de la requête : " . $conn->error;
    }
} else {
    echo "Méthode non autorisée.";
}
