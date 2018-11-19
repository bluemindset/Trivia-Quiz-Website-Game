<?php
session_start();
function gather_player(){
    $names= array();
    $damp_scores = array();
    $names_s= array();
    $scores= array();
    $size =0;
    $fp = fopen("players.txt", "r") or die("Unable to open file!");
    while ($line = stream_get_line($fp, 1024 * 1024, "\n")) {
            $size++;
            array_push($names,$line);
    }
        foreach($names as $key => $value){
            $names_e= explode(":",$value);
            array_push($names_s,$names_e[0]);
            array_push($scores,$names_e[1]);
        }

        $damp_scores = $scores;
        rsort($scores);
        array_keys($damp_scores);
        array_keys($names_s);
        $orderednames = array();
        
        foreach($scores as $key => $sorted){
                $where = 0;
            foreach($damp_scores as $key => $non ){        
                if( $sorted == $non  ){
                    print($names_s[$where]);
                    $orderedname = $names_s[$where]." ".$sorted;
                    array_push($orderednames,$orderedname);
                    array_splice($names_s, $where, 1);
                    array_splice($damp_scores, $where, 1);
                    print_r($names_s);
                    break;
                }
                $where++;
            }
        }
    $_SESSION["order"] = $orderednames;
   // print_r($orderednames);
}
?>
<html lang="en">
  <head>
    <!--Metadata - Title,author, desc,keywords,etc-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="author" content="Stephanos Ioannou">
    <meta name="description" content="Questionary game">
    <meta name="keywords" content="Questions,Game">
    <!--Favicon Compatibility-->
    <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">

    <title>Question Game CS 425</title>

    <!-- Bootstrap core CSS -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
  </head>

<body>
<body class="text-center">
 <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
   <header class="masthead mb-auto">
     <div class="inner">          
        <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
            <a class="navbar-brand"style= "color:black" >Question Game</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <form class="form-inline my-2 my-lg-0" >
                <a class="nav-link" href="index.php" type="submit">Home</a>
                </form>
                <li class="nav-item active">
                    <a class="nav-link" href = "scores.php">Scores</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary " href="help.php">Help</a>
                </li>
            </div>
        </nav>
       
<div  class="container">
            <h1 style="margin-top: 100px;color:black; "class="cover-heading">Question Game</h1>
            <h2 class="cover-heading">Help</h2>
            <p class="lead">This game implementation is an exercise in CS425 Internet Techonolgies,University of Cyprus.
            Just click play and answer each question.Press next to go to the next and finish to end the game and save your score
            Don't refresh the page.In scores sector you can find all the players and their scores.Press home to restart the game.</p>

            </div>

  <footer class="mastfoot fixed-bottom mt-auto">
        <div class="inner">
          <p>Stefanos Ioannou - CS 425 Internet Technologies</p>
          <a href="#0"><i class="fas fa-level-up-alt js-cd-top fa-2x"></i></a><br>
          <i class="fas fa-cat"></i>
          <i class="fas fa-dragon"></i>
        </div>
      </footer>
    </div>


  
    <script src="main.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="../../dist/js/bootstrap.min.js"></script>
  </body>
</html>
