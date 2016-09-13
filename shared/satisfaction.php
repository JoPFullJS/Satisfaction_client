<?php



if(isset($_POST['id']) && isset($_POST['article']) && isset($_POST['val']))
{
  //on creer un tableau des variables pour json_encode.
  $tab = array();

  // Quel bouton a été appuyer par l'utilisateur

  switch($_POST['id'])
		{
		case 0: $vote = 'adore';
		break;
		case 1: $vote = 'satisfait';
		break;
		case 2: $vote = 'neutre';
		break;
		case 3: $vote = 'aime_pas';
		break;
		case 4: $vote = 'deteste';
		break;

		}

  //verification de l'adresse ip locale

  if ($_SERVER["REMOTE_ADDR"] == "::1") {
    $ip = "127.0.0.1";
  }
  else{
    $ip = $_SERVER["REMOTE_ADDR"];
  }

  //encapsulation des variable dans le json

   $tab['ip'] = $ip;

   // Connexion base de données
   $pdo = new PDO('mysql:host=localhost;dbname=satisfaction', 'root', '');

   //On verifie que l'adresse io est deja sur la base de données

   $count="SELECT COUNT(id_ip) AS vote FROM  vote_ip  WHERE id_vote='".$_POST['article']."' AND id_ip='".$ip."'";
   $req_count =  $pdo->query( $count );
   $ip_count = $req_count->fetch();

   if($ip_count['vote'] == 0){

     //Si la personne n'a jamais voter pour cette article

     //Variable retour pour reponse ajax: la personne n'a jamais voter pour cette article
     $tab['ok'] = 0;

     $ajout_ip="INSERT INTO vote_ip SET id_ip='".$ip."',id_vote='".$_POST['article']."',last_id='".$_POST['id']."'";
 		 $req_ajout =  $pdo->query( $ajout_ip );

     if(isset($req_ajout)){

       //on selectinne la valeur de l'élément selectionner dans la base de données
       $ajout_unit="SELECT ".$vote.",compteur FROM compteur WHERE id_vote='".$_POST['article']."'";
       $unit =  $pdo->query($ajout_unit);
       $rs_unit = $unit->fetch();


       if ($rs_unit) {

         // On incremente la variable de +1
         $unit = $rs_unit[$vote]+1;

         switch($vote)
       		{
       		case "adore":
              $insert_vote = "UPDATE compteur SET '".$vote."'='".$unit."' WHERE id_vote='".$_POST['article']."'";
              $req_insert_vote =  $pdo->query($insert_vote);
       		break;
       		case "satisfait":
              $insert_vote = "UPDATE compteur SET '".$vote."'='".$unit."' WHERE id_vote='".$_POST['article']."'";
              $req_insert_vote =  $pdo->query($insert_vote);
       		break;
       		case "neutre":
              $insert_vote = "UPDATE compteur SET '".$vote."'='".$unit."' WHERE id_vote='".$_POST['article']."'";
              $req_insert_vote =  $pdo->query($insert_vote);
       		break;
       		case "aime_pas":
              $insert_vote = "UPDATE compteur SET '".$vote."'='".$unit."' WHERE id_vote='".$_POST['article']."'";
              $req_insert_vote =  $pdo->query($insert_vote);
       		break;
       		case "deteste":
              $insert_vote = "UPDATE compteur SET '".$vote."'='".$unit."' WHERE id_vote='".$_POST['article']."'";
              $req_insert_vote =  $pdo->query($insert_vote);
       		break;

       		}

       }


     }

   }
   else if ($ip_count['vote'] == 1) {

   }


  echo  json_encode($tab);
}

 ?>
