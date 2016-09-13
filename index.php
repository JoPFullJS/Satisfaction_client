<?php
$pdo = new PDO('mysql:host=localhost;dbname=satisfaction', 'root', '');

   $req="SELECT id_vote,adore,satisfait,neutre,aime_pas,deteste FROM compteur WHERE id_vote='123456'";
   $query =  $pdo->query($req);
   $listVerif = $query->fetch(PDO::FETCH_OBJ);
   //echo sizeof($listVerif).'<br>';

 ?>
    <!DOCTYPE html>
    <html lang="fr-FR">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-1.12.3.min.js" integrity="sha256-aaODHAgvwQW1bFOGXMeX+pC4PZIPsvn2h1sArYOhgXQ=" crossorigin="anonymous"></script>
        <!-- <script type="text/javascript" src="js/prod.js"></script> -->
        <title>Test Jquery .eq() et json</title>
    </head>

    <body>
        <script type="text/javascript">
            $(document).ready(function() {

                $('.box').click(function(event) {

                //  var current = event.currentTarget; // event.currentTarget == this
                //  var target = event.target; // element qui à ete cliqué

                    var article = <?php echo $listVerif->id_vote; ?>; //identifiant de l'article
                    var nbBox = $(this).index();  //on obtient le numero du bloc
                    //console.log(nbBox);
                    //var text =  $('.box>p').eq(box).html(box);
                    var valBox = $('.box').find('p').find('span').eq(nbBox).html(); //on selectionne l'element numero nbBox et le contenu html
                    //console.log(text);

                    //console.log(valeur);
                    $.ajax({
                        type: "POST",
                        url: 'shared/satisfaction.php',
                        data: {
                          article:article,
                          id: nbBox,
                          val: valBox
                        },
                        beforeSend: function() {
                        },
                        success: function(data) {
                        //  console.log(data);
                          //$('#container').append(data);
                          if(data.ok == 0){

                            console.log(data.ok);
                            console.log("data.ok");
                            //var plusBox = parseInt(data.val)+1;
                            $('.box').find('p').find('span').eq(data.id).html(data.val);

                            console.log(data.ip);
                          }
                          else if(data.ok == 1){
                            console.log(data.ok);
                            $('.box').find('p').find('span').eq(2).html(data.val);

                            // var plusBox = parseInt(data.val)+1;
                            // $('.box').find('p').find('span').eq(data.id).html(plusBox);
                            // var moinsBox = parseInt(data.val)-1;
                            // $('.box').find('p').find('span').eq(2).html(moinsBox);
                            //console.log(calc);

                          }



                        },
                        error: function() {

                        },
                        dataType: "json"
                    });
                    // $('#container').append('<p> Identifiant box : ' + nbBox + '</p>');
                    // $('#container').append('<p> valeur box : ' + valBox + '</p>');


                    //console.log('bonjour');
                });

            });
        </script>

        <div id="container">
            <div class="box">
                <div style="text-align: center;"><img src="img/adore.png" alt=""></div>
                <p>
                    <span><?php echo $listVerif->adore; ?></span>
                </p>
            </div>
            <div class="box">
                <div style="text-align: center;"><img src="img/satisfait.png" alt=""></div>
                <p>
                    <span><?php echo $listVerif->satisfait; ?></span>
                </p>
            </div>
            <div class="box">
                <div style="text-align: center;"><img src="img/neutre.png" alt=""></div>
                <p>
                    <span><?php echo $listVerif->neutre; ?></span>
                </p>
            </div>
            <div class="box">
                <div style="text-align: center;"><img src="img/aime_pas.png" alt=""></div>
                <p>
                    <span><?php echo $listVerif->aime_pas; ?></span>
                </p>
            </div>
            <div class="box">
                <div style="text-align: center;"><img src="img/deteste.png" alt=""></div>
                <p>
                    <span><?php echo $listVerif->deteste; ?></span>
                </p>
            </div>
        </div>

    </body>

    </html>
