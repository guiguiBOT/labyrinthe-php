<?php
session_start();

// Déclaration des tableaux
$map = [
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 1, 0, 3, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 3, 0, 0],
    [0, 0, 3, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 3, 0, 0, 0],
    [0, 3, 0, 3, 0, 0, 2, 0],
    [0, 0, 0, 0, 0, 0, 0, 0]
];

$map2 = [
    [0, 0, 0, 0, 0, 3, 0, 0],
    [0, 1, 0, 3, 0, 0, 0, 2],
    [0, 0, 3, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 3, 0, 0],
];

$fog = [
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
];

$fog2 = [
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5],
    [5, 5, 5, 5, 5, 5, 5, 5]
];

if (isset($_POST['reload'])) {
    // session_destroy();
    // header('refresh:0');
    $_SESSION['toggle'] = !$_SESSION['toggle'];
    if ($_SESSION['toggle'] === true) {
        $_SESSION['map'] = $map2;
    } else {
        $_SESSION['map'] = $map;
    }
}
if (!isset($_POST['reload']) && !isset($_POST['up']) && !isset($_POST['right']) && !isset($_POST['down']) && !isset($_POST['left'])){
    $_SESSION['toggle'] = false;
}

if (!isset($_SESSION['map'])) {
    if ($_SESSION['toggle'] === true) {
        $_SESSION['map'] = $map2;
    } else {
        $_SESSION['map'] = $map;
    }
}

if (isset($_POST)) {
    movePlayer($_SESSION['map']);
}  



$_SESSION['wrongMsg'] = '';
$_SESSION['winMsg'] = '';



// $_SESSION['map'] = isset($_SESSION['map']) ? ($_SESSION['map']) : (
// $_SESSION['toggle'] ? $map2 : $map);



function displayGrid($nuage)
{
    $formatFog = activeFog($_SESSION['map'], $nuage);
    for ($i = 0; $i < sizeof($formatFog); $i++) {
        for ($j = 0; $j < sizeof($formatFog[$i]); $j++) {
            switch ($formatFog[$i][$j]) {
                case 0:
                    echo "<div class='cell'></div>";
                    break;
                case 1:
                    echo "<div class='cellCat'></div>";
                    break;
                case 3:
                    echo "<div class='cellWall'></div>";
                    break;
                case 2:
                    echo "<div class='cellMouse'></div>";
                    break;
                case 4:
                    echo "<div class='cellWin'></div>";
                    break;
                case 5:
                    echo "<div class='cellFog'></div>";
                default:
                    break;
            }
        }
    }
}

function movePlayer($array)
{
    foreach ($array as $i => $line) {
        foreach ($line as $j => $cell) {
            if ($cell === 1 && isset($_POST['up'])) {
                if ($i === 0 || $array[$i - 1][$j] === 3) {
                    $_SESSION['wrongMsg'] = "mauvaise direction !";
                } else if ($array[$i - 1][$j] !== 3) {
                    if ($array[$i - 1][$j] === 2) {
                        $array[$i][$j] = 0;
                        $array[$i - 1][$j] = 4;
                        $_SESSION['winMsg'] = "La sourie est décédée !";
                    } else {
                        $array[$i][$j] = 0;
                        $array[$i - 1][$j] = 1;
                    }
                }
            } else if ($cell === 1 && isset($_POST['down'])) {
                if ($i === sizeof($array) - 1 || $array[$i + 1][$j] === 3) {
                        $_SESSION['wrongMsg'] = "mauvaise direction !";
                } else if ($array[$i + 1][$j] !== 3) {
                    if ($array[$i + 1][$j] === 2) {
                        $array[$i][$j] = 0;
                        $array[$i + 1][$j] = 4;
                        $_SESSION['winMsg'] = "La sourie est décédée !";
                    } else {
                        $array[$i][$j] = 0;
                        $array[$i + 1][$j] = 1;
                    }
                }
            } else if ($cell === 1 && isset($_POST['left'])) {
                if ($j === 0 || $array[$i][$j - 1] === 3) {
                    $_SESSION['wrongMsg'] = "mauvaise direction !";
                } else if ($array[$i][$j - 1] !== 3) {
                    if ($array[$i][$j - 1] === 2) {
                        $array[$i][$j] = 0;
                        $array[$i][$j - 1] = 4;
                        $_SESSION['winMsg'] = "La sourie est décédée !";
                    } else {
                        $array[$i][$j] = 0;
                        $array[$i][$j - 1] = 1;
                    }
                }
            } else if ($cell === 1 && isset($_POST['right'])) {
                if ($j === sizeof($line) - 1 || $array[$i][$j + 1] === 3) {
                    $_SESSION['wrongMsg'] = "mauvaise direction !";
                } else if ($array[$i][$j + 1] !== 3) {
                    if ($array[$i][$j + 1] === 2) {
                        $array[$i][$j] = 0;
                        $array[$i][$j + 1] = 4;
                        $_SESSION['winMsg'] = "La sourie est décédée !";
                    } else {
                        $array[$i][$j] = 0;
                        $array[$i][$j + 1] = 1;
                    }
                }
            }
        }
    }
    $_SESSION['map'] = $array;
}

function activeFog($array, $array2)
{
    foreach ($array as $i => $line) {
        foreach ($line as $j => $cell) {
            if ($cell === 4) {
                $array2[$i][$j] = 4;
                return $array2;
            }
            if ($cell === 1) {
                $array2[$i][$j] = 1;
                if (isset($array[$i - 1][$j])) $array2[$i - 1][$j] = $array[$i - 1][$j];
                if (isset($array[$i + 1][$j])) $array2[$i + 1][$j] = $array[$i + 1][$j];
                if (isset($array[$i][$j - 1])) $array2[$i][$j - 1] = $array[$i][$j - 1];
                if (isset($array[$i][$j + 1])) $array2[$i][$j + 1] = $array[$i][$j + 1];
            }
        }
    }
    return $array2;
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labyrinthe</title>
    <link rel="stylesheet" href="./assets/style/style.css">
</head>

<body>
    <header>
        <H1>The Ultimate F*cking Greatest Maze</H1>
    </header>
    <main>
        <div id="gameContainer">
            <div id="boardContainer">
                <?php displayGrid($_SESSION['toggle'] ? $fog2 : $fog); ?>
            </div>
            <div id="arrowContainer">
                <form id="formDirection" method="post">
                    <div id="upBtnContainer">
                        <input class="button" id="upBtn" type="submit" value="up" name="up"></input>
                    </div>
                    <div id="leftAndRightBtnContainer">
                        <input class="button" id="leftBtn" type="submit" value="left" name="left"></input>
                        <input class="button" id="rightBtn" type="submit" value="right" name="right"></input>
                    </div>
                    <div id="downBtnContainer">
                        <input class="button" id="downBtn" type="submit" value="down" name="down"></input>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <footer>

        <div id="wronMsg"><?php echo $_SESSION['wrongMsg']?></div>
        <div id="winMsg"><?php echo $_SESSION['winMsg']?></div>
        <form method="post">
            <input class="button" id="reloadBtn" type="submit" value="reload" name="reload"></input>
        </form>
    </footer>
</body>

</html>