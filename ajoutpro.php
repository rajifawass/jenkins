<?php
include('connexion.php');

$requete= "INSERT INTO proprietaire VALUES(?,?,?,?,?)";
if( isset($_POST['num_cni'])){
    $num_cni=$_POST['num_cni'];
    $nom_pren=$_POST['nompren'];
    $date_naiss=$_POST['datenaiss'];
    $telephone=$_POST['tel'];
    $adresse=$_POST['adresse'];
    $table=array($num_cni,$nom_pren,$date_naiss,$telephone,$adresse);
    $prepare=$cnx->prepare($requete);
    $execute=$prepare->execute($table);
    if ($execute== 1){
        $msg="Ajout effectuer avec succes !";
    }
    else{
        $msg="erreur lors de l'ajout !!!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>AJOUTER un proprietaire</h3>
    <div>
    <?php
    if (isset($msg)){
        echo($msg);
    }
    ?>
    </div>
    <form action="ajoutpro.php" method="post">
        <table>
            <tr>
                <td>numero cni :</td>
                <td> <input type="text" name="num_cni"> </td>

            </tr>
            <tr>
                <td> Nom et prenom</td>
                <td> <input type="text" name="nompren"> </td>

            </tr>  <tr>
                <td> Date de naissance : </td>
                <td><input type="date" name="datenaiss"></td>

            </tr>  <tr>
                <td> Telephone :</td>
                <td> <input type="tel" name="tel"></td>

            </tr>  <tr>
                <td> Adresse : </td>
                <td> <input type="text" name="adresse" row="3"></td>

            </tr>  <tr>
                <td></td>
                <td> <input type="submit" value="ajouter"></td>


            </tr>
        </table>
    </form>
</body>
</html>