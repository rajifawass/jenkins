<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

include('connexion.php');

$message = ''; // Message de confirmation

// Vérifiez si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données du formulaire
    $coiffeur = $_POST['coiffeur'];
    $coiffure = $_POST['coiffure'];
    $prix = $_POST['prix'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $statut = 'en attente'; // par défaut

    // Insertion des données dans la table rdv
    $stmt = $conn->prepare("INSERT INTO rdv (coiffeur, coiffure, prix, date, heure, statut) VALUES (:coiffeur, :coiffure, :prix, :date, :heure, :statut)");
    $stmt->bindParam(':coiffeur', $coiffeur);
    $stmt->bindParam(':coiffure', $coiffure);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':heure', $heure);
    $stmt->bindParam(':statut', $statut);

    if ($stmt->execute()) {
        $message = "Réservation réussie";
        header('refresh:2;url=commande.php'); // Redirection vers commande.php après 2 secondes
    } else {
        // Gérez l'erreur, par exemple :
        $message = "Erreur lors de l'ajout de la réservation.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver une coiffure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg custom-navbar-color">
        <div class="container-fluid">
            <a class="navbar-brand" style="color:white" href="index.php">Reflet Radieux</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <a class="nav-link active" style="color:white" aria-current="page" href="admin.php">reserver</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link" style="color:white" href="commande.php">mes commandes</a>
                    </li>
                    <li class="nav-item me-3">
                        <form method="post" action="">
                            <input type="hidden" name="logout" value="true">
                            <button type="submit" class="nav-link"
                                style="background:none; border:none; color:white; cursor:pointer;">Déconnexion <i
                                    class="fa fa-user" aria-hidden="true"></i></button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Réserver une coiffure</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="reservation.php" method="post">
            <div class="mb-3">
                <label for="coiffeur" class="form-label">Coiffeur:</label>
                <select name="coiffeur" id="coiffeur" class="form-control" required>
                    <optgroup label="Homme">

                        <option value="ali">Ali</option>
                        <option value="alex">Alex</option>
                        <option value="albert">Akbert</option>
                    </optgroup>

                    <optgroup label="Femme">

                        <option value="awa">awa</option>
                        <option value="emmanuella">emmanuella</option>
                        <option value="sarah">sarah</option>
                    </optgroup>

                </select>
            </div>
            <div class="mb-3">
                <label for="coiffure" class="form-label">Coiffure:</label>
                <select name="coiffure" id="coiffure" class="form-control" required>
                    <optgroup label="Homme">
                        <option value="punch">Punch</option>
                        <option value="taper bas">Taper bas</option>
                        <option value="tectonic">Tectonic</option>
                        <option value="degrade">Dégradé</option>
                    </optgroup>
                    <optgroup label="Femme">
                        <option value="coupe">Coupe</option>
                        <option value="afro">Afro</option>
                        <option value="natte">Natte</option>
                        <option value="perruque">Perruque</option>
                    </optgroup>
                </select>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix:</label>
                <input type="text" name="prix" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="heure" class="form-label">Heure:</label>
                <input type="time" name="heure" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Réserver</button>
        </form>
    </div>

    <style>
        .custom-navbar-color {
            background-color: #7F00FF;
        }
    </style>

</body>

</html>