<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Pokedex</title>
</head>
<body>
<?php
$API = "https://pokeapi.co/api/v2/pokemon/";

if(isset($_GET["poke-id"])===false){
    $pokeID =1;
}else{
    $pokeID = $_GET["poke-id"];
}
$jsonData = file_get_contents($API . $pokeID);//fetching
$pokeDecode = json_decode($jsonData);
$speciesURL = $pokeDecode->species->url;
?>
<div id="pokedex">

    <!-- the left container -->
    <div id="left-panel">
        <div id="top-left"></div>
        <div id="top-left1">
            <div id="blue-button">
                <div id=reflect"></div>
            </div>
            <!-- three small light -->
            <div id="top-buttons">
                <div id="top-red-button"></div>
                <div id="top-yellow-button"></div>
                <div id="top-green-button"></div>
            </div>
        </div>
        <!-- screen part -->
        <div id="top-left2">
            <div id="border-screen">
                <div id="button-top1"></div>
                <div id="button-top2"></div>
            </div>
            <!-- screen -->
            <div id="screen">
                <img id="actualEvoImg" src="<?php echo $pokeDecode->sprites->front_default ?>" alt="pokemon">
            </div>
            <!-- below screen -->
            <div class="material">
                <form action="index.php" method="get">
                    <label for="poke-id"></label>
                    <input type="text" name="poke-id" id="poke-id" placeholder="Id or Name"/>
                    <br>
                    <input type="submit" id="run"/>
                </form>
            </div>

            <div id="display-id">
                <span id="show-id">
                    <?php echo $pokeDecode->id ?>
                </span>
            </div>
        </div>
    </div>
    <!-- middle -->
    <div id="middle">
        <div id="hinge1"></div>
        <div id="hinge2"></div>
        <div id="hinge3"></div>
    </div>
    <!-- the right container -->
    <div id="right-panel">
        <div id="top-right"></div>

        <!-- information screen -->
        <div id="info-screen">

            <div class="poke">
                <h4 class="title">
                    <strong class="name">
                        <?php echo $pokeDecode->name ?>
                    </strong>
                </h4>
            </div>
        </div>

        <?php shuffle($pokeDecode->moves);
        foreach(array_slice($pokeDecode->moves, 0 ,4) AS $index=> $value){

            echo '<p class="move" id="move'.($index+1).'">'. $value->move->name .'</p>';
        }?>


             <?php /*
           if (!isset($pokeDecode->moves[0])) {
              echo " - ";
             }else{
               echo  $pokeDecode->moves[0]->move->name;
        }?></p>

        <p class="move" id="move2">
            <?php shuffle($pokeDecode->moves);
            foreach(array_slice($pokeDecode->moves, 0 ,4) AS $value){
                echo "<p>".$value->move->name ."</p>" ;
            }?>
            <?php
            if (!isset($pokeDecode->moves[1])) {
                echo " - ";
            }else{
                echo  $pokeDecode->moves[1]->move->name;
            }?></p>

        <p class="move" id="move3"><?php
            if (!isset($pokeDecode->moves[2])) {
                echo " - ";
            }else{
                echo  $pokeDecode->moves[2]->move->name;
            }?></p>

        <p class="move" id="move4"><?php
            if (!isset($pokeDecode->moves[3])) {
                echo " - ";
            }else{
                echo  $pokeDecode->moves[3]->move->name;
            }*/?>

        <div id="prevEvo">
            <?php
            $jsonData = file_get_contents($speciesURL);//fetching
            $prevEvoDecode = json_decode($jsonData);

            if ($prevEvoDecode->evolves_from_species === null) {
                $prevEvoPic = "";
                $prevEvoName = "";
                $noDisplay= "display:none";

            } else {
                $prevEvoName = $prevEvoDecode->evolves_from_species->name;
                $jsonData = file_get_contents($API . $prevEvoName);// fetching pre evolution data
                $prevEvoPokemon = json_decode($jsonData);
                $prevEvoPic = $prevEvoPokemon->sprites->front_default;
                $noDisplay= "";
            }
            ?>
            <form action="index.php" method="get">
                <input style="<?php echo $noDisplay?>" type="image" src="<?php echo $prevEvoPic ?>" id="previousEvoImg"/>
                <input type="hidden" value="<?php echo $prevEvoName ?>" name="poke-id"/>
            </form>
            <b><em class="evolutions"></em>
                <?php
                echo $prevEvoName;
                ?></b>
        </div>
    </div>

</div>

</body>
</html>