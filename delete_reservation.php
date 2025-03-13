<?php
include 'connexion.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Suppression de la réservation
    $stmt = $conn->prepare("DELETE FROM rdv WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $message = "Réservation réussie";
        header('refresh:2;url=super_admin.php'); // Redirection vers commande.php après 2 secondes
    } else {
        // Gérez l'erreur, par exemple :
        $message = "Erreur lors de l'ajout de la réservation.";
    }
} else {
    $message = "Identifiant de réservation non spécifié.";
}

?>
