<?php
include('connexion.php') ;
$requete = "SELECT * FROM proprietaire ";
$prepare = $cnx->prepare($requete);
$execute = $prepare->execute(); 
$affiche=$prepare-> fetch(PDO:: FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
    <h1>LISTE DES PROPRIETAIRE</h1> <br> <hr> <br>
    <table border="1" style="border-collapse:collapse;border:1px solid #000">
        <tr>
            <td>numero cni</td>
            <td>nom et prenoms</td>
            <td>date de naissance</td>
            <td>telephone</td>
            <td>adresse</td>
            <td>Modifier</td>
            <td>Supprimer</td>

        </tr>
        <?php
        do{

       
        ?>
           <tr>
            <td><?php   echo $affiche["num_cni_pro"];   ?></td>
            <td><?php   echo $affiche["nom_prenom_pro"];   ?></td>
            <td><?php   echo $affiche["date_naiss_pro"];   ?></td>
            <td><?php   echo $affiche["tel_pro"];   ?></td>
            <td><?php   echo $affiche["adresse_pro"];   ?></td>
            
            <td> <a href="modifpro.php?id=<?php   echo $affiche["num_cni_pro"];   ?>"> <i class="fa-solid fa-pencil"></i></a></td>


            <td><a href="supprimepro.php?id=<?php   echo $affiche["num_cni_pro"];   ?>" onclick="return(confirm('voulez vous reelement supprimer ?'))"  >  <i class="fa-solid fa-trash"></i></a></td>

        </tr>
        <?php
        }while($affiche=$prepare-> fetch(PDO:: FETCH_ASSOC));

       
        ?>
    </table>
   
</body>
</html>

