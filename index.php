
<?php
session_start();

$_SESSION["con"] =0;

/*If home is pressed reset the session and start from the beginning.*/
if(isset($_REQUEST["home"])){ 
    session_destroy();
    unset($_REQUEST["home"]);
    header("Refresh:0; url=index.php");
}

function insert_player($player , $score){
    $file = fopen("players.txt", "a+") or die("Unable to open file!");
    fwrite($file, $player);
    fwrite($file, ":");
    fwrite($file, $score);
    fwrite($file, "\n");
}
function prepare_answers($title_s,$answer_s,$noanswer1_s,$noanswer2_s,&$title,&$answers){
    $title = $title_s;
    $answers[] = $answer_s;
    $answers[] = $noanswer1_s;
    $answers[] = $noanswer2_s;
    $_SESSION["correct_answer"]= $answer_s;    
    $_SESSION["counter_q"]++;
}
function is_correct($s1,$s2){
    if (strcmp($s1, $s2)==0){
        return true;
    }
        return false;
}
/*Insert them inside session array*/
    /*Since session does not store xml object array we must ave
      easy questions easy answers easynoanswers1 easynoanswers2
      same for medium and hard*/
 if(isset($_REQUEST["welcome"])){ 
    $min = 0;
    $max = 4;
    $difficulty =2;
    $numbers = array();
    $numbers = range(0, 23);
    shuffle($numbers);
    $random_nums = array_slice($numbers, 0, 5);
    $_SESSION["time"] = 0;
    $_SESSION["random_nums"]= array();
    $_SESSION["random_nums"]=  $random_nums;
    $_SESSION["counter_q"]=0;
    $_SESSION['difficulty'] = 2; //Medium
    $_SESSION['easy_questions'] = array();
    $_SESSION['easy_answers'] = array();
    $_SESSION['easy_noanswers1'] = array();
    $_SESSION['easy_noanswers2'] = array();
    $_SESSION['med_questions'] = array();
    $_SESSION['med_answers'] = array();
    $_SESSION['med_noanswers1'] = array();
    $_SESSION['med_noanswers2'] = array();
    $_SESSION['hard_questions'] = array();
    $_SESSION['hard_answers'] = array();
    $_SESSION['hard_noanswers1'] = array();
    $_SESSION['hard_noanswers2'] = array();
    $_SESSION["asked_question"]=array();
    $_SESSION["user_answers"] =array();
    $_SESSION["real_answers"] =array();
    $_SESSION["level"]=array();
    $_SESSION["welcome"]= 0; 
    $_SESSION["user"] = $_POST["user"]; 

    $questions = simplexml_load_file('questions.xml');
    foreach($questions as $question)
    {
      if (strcmp($question["category"],"easy")==0){
        $no_answer=array();
        $no_answer = $question->noanswer;
        $no_answer1 = (string)$no_answer[0];
        $no_answer2 = (string)$no_answer[1];
        array_push( $_SESSION['easy_questions'], (string)$question->question_title);
        array_push( $_SESSION['easy_answers'], (string)$question->answer);
        array_push( $_SESSION['easy_noanswers1'], $no_answer1);
        array_push( $_SESSION['easy_noanswers2'], $no_answer2);
      }
      if (strcmp($question["category"],"medium")==0){
        $no_answer=array();
        $no_answer = $question->noanswer;
        $no_answer1 = (string)$no_answer[0];
        $no_answer2 = (string)$no_answer[1];
        array_push( $_SESSION['med_questions'], (string)$question->question_title);
        array_push( $_SESSION['med_answers'], (string)$question->answer);
        array_push( $_SESSION['med_noanswers1'], $no_answer1);
        array_push( $_SESSION['med_noanswers2'], $no_answer2);
      }
      if (strcmp($question["category"],"hard")==0){
        $no_answer=array();
        $no_answer = $question->noanswer;
        $no_answer1 = (string)$no_answer[0];
        $no_answer2 = (string)$no_answer[1];
        array_push( $_SESSION['hard_questions'], (string)$question->question_title);
        array_push( $_SESSION['hard_answers'], (string)$question->answer);
        array_push( $_SESSION['hard_noanswers1'], $no_answer1);
        array_push( $_SESSION['hard_noanswers2'], $no_answer2);
      }
    }
}
if (isset($_REQUEST["end"])){

    $_SESSION["end"]=1;
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" >
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">
  </head>

  <body class="text-center">
 
    <div class="cover-container d-flex h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">          
        <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
        <a class="navbar-brand" style= "color:black">Question Game</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
        <form class="form-inline my-2 my-lg-0" >
             <input class="btn btn-primary"method="post" type="submit" value="Home" name="home">
        </form>
        <li class="nav-item ">
         <a class="nav-link" href ="scores.php" >Scores</a>
        </li>
        <li >
        <a class="nav-link" href="help.php">Help</a>
      </li>
  </div>
 </nav>
 </div>
      </header>
      <?php
      if (isset($_SESSION["end"])&& $_SESSION["counter_q"]<6 && is_correct($_POST["user"],"")){
            array_push($_SESSION["user_answers"],$_POST["user_answer"]);
            array_push($_SESSION["real_answers"],$_SESSION["correct_answer"]);
            ?>
            <main role="main" class="inner cover">
            <h1 style="margin-top: 100px;color:black; " class="cover-heading">Game Finish!</h1>
    
            <div class = "row">
                <div class = "col">
                        <ul class="list-group">
                        <?php 
                        $score =0;
                        for($i=0; $i<5; $i++){
                            $s =0;
                            if (is_correct($_SESSION["level"][$i],"medium"))
                                $s = 5;
                            if (is_correct($_SESSION["level"][$i],"easy"))
                                $s = 1;
                            if (is_correct($_SESSION["level"][$i],"hard"))
                                $s = 10;
                            if (is_correct($_SESSION["user_answers"][$i+1],$_SESSION["real_answers"][$i])){
                                $answered =  "CORRECT";
                                $score =$score+$s;
                                echo "<li style=\"color:green;\">" .($i+1) . "." . $_SESSION["asked_question"][$i] . "<br> You answered: " . $_SESSION["user_answers"][$i+1]. "<br>  Answer is:  ". $_SESSION["real_answers"][$i] . "<br> Level: " . $_SESSION["level"][$i] . "<br> Points: ".$s."<br>".$answered."</li>"; 
                         
                            }
                            else{ 
                                $answered = "FALSE"; 
                                echo "<li style=\"color:maroon;\">" .($i+1) . "." . $_SESSION["asked_question"][$i] . "<br> You answered: " . $_SESSION["user_answers"][$i+1]. "<br>  Answer is:  ". $_SESSION["real_answers"][$i] . "<br> Level: " . $_SESSION["level"][$i] . "<br> Points: ".$s."<br>".$answered."</li>"; 
                            }
                            
                        }
                        $_SESSION["score"] = $score;

                        ?>
            </ul>
            <h2 class="cover-heading"style= "color:black"><br><?php echo " SCORE : "; echo $score; ?> </h2> 
            <h3>Save your name or press home: </h3>
            <form action="index.php" name="welcome1" method="post">
                    <input type="text" placeholder="Username" id="usr" name="user">
                    <input class="btn btn-lg btn-primary " type="submit" value="save" name="homesave">        
            </form>
           
        </main>
    <?php }
    
    if(isset($_REQUEST["homesave"])&& is_correct($_POST["user"],""))
             echo  "<h2 class=\"cover-heading\"> ". $_POST["user"] . " Enter a username!</h2>";

    if(isset($_REQUEST["homesave"])&& !is_correct($_POST["user"],"")){
        insert_player($_POST["user"] ,  $_SESSION["score"] );
        echo  "<h2 class=\"cover-heading\"> ". $_POST["user"] . " your name is saved! Press home to go to the beggining</h2>"; 
    }
    else if (!isset($_SESSION["welcome"])){ ?>
            <main role="main" class="inner cover">
                <h1 class="cover-heading">Are you ready to play the game?</h1>
                <h2 class="cover-heading">Show to the world your knowledge</h2>
                <p class="lead">This game implementation is an exercise in CS425 Internet Techonolgies,University of Cyprus</p>
                
                <form action="index.php" name="welcome1" method="post">
                    <input class="btn btn-lg btn-primary " type="submit" value="Play!" name="welcome">        
                </form>
                
            </main>
      <?php 
       } else { 
                $title;
                $answers =array();
                $c = $_SESSION["counter_q"];
                $r = array();
                $r = $_SESSION["random_nums"];
                $a = $r[$c];
                $numbers = range(0, 2);
                shuffle($numbers);
                $random = array_slice($numbers, 0, 3);
                $level = "medium";
                if(isset($_REQUEST["next"]) && isset($_POST["user_answer"])  && is_correct($_POST["user_answer"],$_SESSION["correct_answer"])){ 
                    $_SESSION["con"] = 1;
                   
                    switch ($_SESSION["difficulty"]) {
                        case 1:
                                prepare_answers($_SESSION["med_questions"][$a],$_SESSION["med_answers"][$a],$_SESSION["med_noanswers1"][$a],$_SESSION["med_noanswers2"][$a],$title,$answers);
                                $level = "medium";
                                $_SESSION["difficulty"]++; 
                                
                                break;
                        case 2: 
                                prepare_answers($_SESSION["hard_questions"][$a],$_SESSION["hard_answers"][$a],$_SESSION["hard_noanswers1"][$a],$_SESSION["hard_noanswers2"][$a],$title,$answers);
                                $level = "hard";
                                $_SESSION["difficulty"]++; 
                              
                                break;

                        case 3:    
                                prepare_answers($_SESSION["hard_questions"][$a],$_SESSION["hard_answers"][$a],$_SESSION["hard_noanswers1"][$a],$_SESSION["hard_noanswers2"][$a],$title,$answers);
                                $level = "hard";
                                
                                break;
                    }

                }
               else if(isset($_REQUEST["next"]) && !is_correct($_POST["user_answer"],$_SESSION["correct_answer"])){
                $_SESSION["con"] = 1;
                   
                    switch ($_SESSION["difficulty"]) {
                        case 2: $level = "easy";
                                prepare_answers($_SESSION["easy_questions"][$a],$_SESSION["easy_answers"][$a],$_SESSION["easy_noanswers1"][$a],$_SESSION["easy_noanswers2"][$a],$title,$answers);
                                $_SESSION["difficulty"]--; 
                                break;
                        case 3: $level = "medium";
                                prepare_answers($_SESSION["med_questions"][$a],$_SESSION["med_answers"][$a],$_SESSION["med_noanswers1"][$a],$_SESSION["med_noanswers2"][$a],$title,$answers);
                                $_SESSION["difficulty"]--; 
                                break;

                        case 1: $level = "easy";        
                               prepare_answers($_SESSION["easy_questions"][$a],$_SESSION["easy_answers"][$a],$_SESSION["easy_noanswers1"][$a],$_SESSION["easy_noanswers2"][$a],$title,$answers);
                                break;
                    }

                }else if($_SESSION["time"]==0){ 
                    prepare_answers($_SESSION["med_questions"][$a],$_SESSION["med_answers"][$a],$_SESSION["med_noanswers1"][$a],$_SESSION["med_noanswers2"][$a],$title,$answers);
                    $_SESSION["time"] = 1;
                    $_SESSION["con"] = 1;
                } 
                array_push($_SESSION["asked_question"],$title);
               
                array_push($_SESSION["level"],$level);
                
          if ($_SESSION["counter_q"] < 5 && $_SESSION["con"] ==1 ){
            

           ?>
                <main role="main" class="inner cover">
                <h1 class="cover-heading"> Question <?php echo ($c+1)."/5"; ?></h1>
                <h2 class="cover-heading"><?php print($title)?> </h2>
                <form  action=""  method="post">
                    <div>
                        <input class="form-check-input" type="radio" name="user_answer" id="answerRadio1"<?php echo 'value="';echo $answers[$random[0]];echo'"checked>'; ?>
                        <label class="form-check-label" for="answerRadio1">
                            <?php echo $answers[$random[0]]; ?>
                        </label>
                    </div>
                    
                    <div>
                        <input class="form-check-input" type="radio" name="user_answer" id="answerRadio2" <?php echo 'value="';echo $answers[$random[1]];echo'">'; ?>
                        <label class="form-check-label" for="answerRadio2">
                            <?php echo $answers[$random[1]]; ?>
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="user_answer" id="answerRadio3" <?php echo 'value="';echo $answers[$random[2]];echo'">'; ?>
                        <label class="form-check-label" for="answerRadio3">
                            <?php echo $answers[$random[2]]; ?>
                        </label>
                        </div>
                    
                        <div>
                        <input style = "margin-top :50px;"class=" btn btn-lg btn-success " type="submit" value="Next" name="next">        
                        </div>
                   </form>
          </main>

                   
         
       
      <?php } else if ($_SESSION["con"] ==1) {?>
        <main role="main" class="inner cover">
                <h1 class="cover-heading"> Question <?php echo ($c+1)."/5"; ?></h1>
                <h2 class="cover-heading"><?php print($title)?> </h2>
                <form  action=""  method="post">
                    <div>
                        <input class="form-check-input" type="radio" name="user_answer" id="answerRadio1"<?php echo 'value="';echo $answers[$random[0]];echo'"checked>'; ?>
                        <label class="form-check-label" for="answerRadio1">
                            <?php echo $answers[$random[0]]; ?>
                        </label>
                    </div>
                    
                    <div>
                        <input class="form-check-input" type="radio" name="user_answer" id="answerRadio2" <?php echo 'value="';echo $answers[$random[1]];echo'">'; ?>
                        <label class="form-check-label" for="answerRadio2">
                            <?php echo $answers[$random[1]]; ?>
                        </label>
                    </div>
                    <div>
                        <input class="form-check-input" type="radio" name="user_answer" id="answerRadio3" <?php echo 'value="';echo $answers[$random[2]];echo'">'; ?>
                        <label class="form-check-label" for="answerRadio3">
                            <?php echo $answers[$random[2]]; ?>
                        </label>
                        </div>
                    
                        <div>
                        <input style = "margin-top :50px;"class=" btn btn-lg btn-success " type="submit" value="Finish" name="end">        
                        </div>
                   </form>
          </main>
    <?php 
         } 
          
    }
  
    array_push($_SESSION["user_answers"],$_POST["user_answer"]);
    array_push($_SESSION["real_answers"],$_SESSION["correct_answer"]);
      if($_SESSION["con"]==0 && $_SESSION["time"]==1 && $_SESSION["end"]!=1 ){
          echo' <h2 class="cover-heading">You have left the game by mistake. Press home again.</h2>';
      }
      $_SESSION["con"] =0;
      if(isset($_POST["user"])){
        $_SESSION["user"] = $_POST["user"];
      }
      
      unset($_POST);
      unset($_REQUEST);
      unset($answers);
      ?>
      
      <footer class="mastfoot mt-auto">
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
