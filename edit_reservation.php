<?php
session_start();

if(isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

include('connexion.php');

// Vérifiez si l'identifiant de la réservation est passé dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Récupérez les détails de la réservation à modifier depuis la base de données
    $stmt = $conn->prepare("SELECT * FROM rdv WHERE id = :id");
    $stmt->bindParam(':id', $reservation_id);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        echo "Réservation non trouvée.";
        exit();
    }
} else {
    header('refresh:1;url=super_admin.php'); // Redirection vers commande.php après 2 secondes
    exit();
}

// Vérifiez si le formulaire de modification a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les nouvelles valeurs des champs
    $coiffeur = $_POST['coiffeur'];
    $coiffure = $_POST['coiffure'];
    $prix = $_POST['prix'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $statut = $_POST['statut'];

    // Mettez à jour la réservation dans la base de données
    $stmt = $conn->prepare("UPDATE rdv SET coiffeur = :coiffeur, coiffure = :coiffure, prix = :prix, date = :date, heure = :heure, statut = :statut WHERE id = :id");
    $stmt->bindParam(':coiffeur', $coiffeur);
    $stmt->bindParam(':coiffure', $coiffure);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure', $heure);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':id', $reservation_id);

    if ($stmt->execute()) {
        // Redirigez vers la page admin.php après la modification
        header('Location: edit_reservation.php');
        exit();
    } else {
        echo "Erreur lors de la modification de la réservation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg custom-navbar-color">
  <!-- Votre code de navbar -->
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Modifier la réservation</h2>
    <form action="edit_reservation.php?id=<?php echo $reservation_id; ?>" method="post">
        <div class="mb-3">
            <label for="coiffeur" class="form-label">Coiffeur:</label>
            <input type="text" name="coiffeur" class="form-control" value="<?php echo $reservation['coiffeur']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="coiffure" class="form-label">Coiffure:</label>
            <input type="text" name="coiffure" class="form-control" value="<?php echo $reservation['coiffure']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix:</label>
            <input type="text" name="prix" class="form-control" value="<?php echo $reservation['prix']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input type="date" name="date" class="form-control" value="<?php echo $reservation['date']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="heure" class="form-label">Heure:</label>
            <input type="time" name="heure" class="form-control" value="<?php echo $reservation['heure']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="statut" class="form-label">Statut:</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="en attente" <?php echo ($reservation['statut'] == 'en attente') ? 'selected' : ''; ?>>En attente</option>
                <option value="accepter" <?php echo ($reservation['statut'] == 'accepter') ? 'selected' : ''; ?>>Accepté</option>
                <option value="annuler" <?php echo ($reservation['statut'] == 'annuler') ? 'selected' : ''; ?>>Annulé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>

<!-- Votre code CSS et JS -->

</body>
</html>
