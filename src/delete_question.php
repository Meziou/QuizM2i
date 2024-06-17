<?php
// A TERMINER


require_once 'config.php';

$id = $_GET['id'];
$_GET['quiz_id'];
$sql = "DELETE FROM questions WHERE id=?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: quiz_update.php?id=");
    } else {
        echo "Erreur : " . $sql . "<br>" . $stmt->error;
    }
} else {
    echo "Erreur lors de la préparation de la requête : " . $conn->error;
}