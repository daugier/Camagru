<?php
if(isset($_FILES['up_photo']))
{
     if (!file_exists('../upload'))
          mkdir('../upload');
     $dossier = '../upload/';
     $fichier = basename($_FILES['up_photo']['name']);
     $extensions = array('.png', '.gif', '.jpg', '.jpeg');
     $extension = strrchr($_FILES['up_photo']['name'], '.');
     $taille_maxi = 1000000;
     $taille = filesize($_FILES['up_photo']['tmp_name']);
     if($taille > $taille_maxi)
          $erreur =  "taille trop importante";
     if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
          $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
     if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
     {
          $fichier = strtr($fichier, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
           'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
          $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
          if(move_uploaded_file($_FILES['up_photo']['tmp_name'], $dossier.$fichier))
                header('location:http://localhost:8080/camagru/php/camera.php?fichier='.$fichier);
     }
     header('location:http://localhost:8080/camagru/php/camera.php?fichier='.$fichier);
}
?>