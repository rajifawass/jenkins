<?php
include('connexion.php');


$requete= "UPDATE proprietaire SET nom_prenom_pro=? ,
           date_naiss_pro=?,
           tel_pro=?,
           adresse_pro=?
           WHERE num_cni_pro=?";

if( isset($_POST['num_cni'])){
    $num_cni=$_POST['num_cni'];
    $nom_pren=$_POST['nompren'];
    $date_naiss=$_POST['datenaiss'];
    $telephone=$_POST['tel'];
    $adresse=$_POST['adresse'];
    $table=array($nom_pren,$date_naiss,$telephone,$adresse,$num_cni);
    $prepare=$cnx->prepare($requete);
    $execute=$prepare->execute($table);
    if ($execute== 1){
        $msg="Mise a jour effectuer avec succes !";
    }
    else{
        $msg="erreur lors de la mise a jours !!!";
    }
}
$requete1="SELECT *FROM proprietaire WHERE num_cni_pro=?";
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $tab=array($id);
    $prepare1=$cnx->prepare($requete1);
    $execute1=$prepare1->execute($tab);
    $donnee=$prepare1-> fetch(PDO::FETCH_ASSOC);
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
    <form action="modifpro.php?id=<?php   echo $donnee["num_cni_pro"];   ?>" method="post">
        <table>
            <tr>
                <td>numero cni :</td>
                <td> <input type="text" name="num_cni" value="<?php echo ((isset($donnee['num_cni_pro'])?$donnee['num_cni_pro']:"" ))?>"> </td>

            </tr>
            <tr>
                <td> Nom et prenom</td>
                <td> <input type="text" name="nompren" value="<?php echo (isset($donnee['nom_prenom_pro'])?$donnee['nom_prenom_pro']:"" )?>"> </td>

            </tr>  <tr>
                <td> Date de naissance : </td>
                <td><input type="date" name="datenaiss" value="<?php echo(isset($donnee['date_naiss_pro'])?$donnee['date_naiss_pro']:"" )?>"></td>

            </tr>  <tr>
                <td> Telephone :</td>
                <td> <input type="tel" name="tel" value="<?php echo(isset($donnee['tel_pro'])?$donnee['tel_pro']:"" )?>"></td>

            </tr>  <tr>
                <td> Adresse : </td>
                <td> <input type="text" name="adresse" value="<?php echo(isset($donnee['adresse_pro'])?$donnee['adresse_pro']:"" )?>"row="3"></td>

            </tr>  <tr>
                <td> <a href="liste.php">retour</a>  </td>
                <td> <input type="submit" value="Modifier"></td>


            </tr>
        </table>
    </form>
</body>
</html>