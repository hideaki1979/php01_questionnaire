<?php
    $ageOp = [
        "10" => "10代",
        "20" => "20代",
        "30" => "30代",
        "40" => "40代",
        "50" => "50代",
        "60" => "60代",
        "70" => "70代"
    ];
    $ramenOp = [
        "soy" => "醤油",
        "salt" => "塩",
        "miso" => "味噌",
        "seafood" => "魚介系",
        "jiro" => "二郎系",
        "house" => "家系",
        "pork" => "とんこつ"
    ];
    $toppingOp = [
        "egg" => "卵",
        "seaweed" => "海苔",
        "garlic" => "にんにく",
        "roastpork" => "チャーシュー",
        "vegetable" => "野菜",
        "ginger" => "しょうが",
        "fat" => "脂"
    ];
    $volumeOp = [
        "100" => "100g台",
        "200" => "200g台",
        "300" => "300g台",
        "400" => "400g台",
        "more500" => "500g以上"
    ];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $ageDisp = "";
    if(isset($ageOp[$age])){
        $ageDisp = $ageOp[$age];
    }
    $ramen = $_POST["ramen"];
    $ramenDisp = "";
    if(isset($ramenOp[$ramen])){
        $ramenDisp = $ramenOp[$ramen];
    }
    $topping = $_POST["topping"];
    $toppingDisp = "";
    if(isset($toppingOp[$topping])){
        $toppingDisp = $toppingOp[$topping];
    }
    $volume = $_POST["volume"];
    $volumeDisp = "";
    if(isset($volumeOp[$volume])){
        $volumeDisp = $volumeOp[$volume];
    }
    $memo = $_POST["memo"];
    $c = ",";
    $str = date("Y年m月d日 H時i分s秒");
    $str .= $c.$name.$c.$email.$c.$ageDisp.$c.$ramenDisp.$c.$toppingDisp.$c.$volumeDisp.$c.$memo;
    $file = fopen("./data/ramendata.csv", "a");
    fwrite($file, $str."\n");
    fclose($file);

    // header("Location: index.php");
    // exit;
?>

<html>
<head>
<?php include("inc/head.html") ?>
<title>アンケート送信完了</title>
</head>
<body>
<?php include("inc/header.html") ?>
<h1>アンケートを送信しました。</h1>
<h2>送信結果はアンケート結果でご確認ください。</h2>
<!-- <?=$str ?> -->
<?php include("inc/foot.html") ?>
</body>
</html>