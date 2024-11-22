<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("inc/head.html") ?>
    <title>アンケート集計結果</title>
</head>
<body>
    <?php include("inc/header.html") ?>
<?php
    $file = fopen("./data/ramendata.csv", "r");
    $ramenData = [];
    echo '<div class="container">
          <table class="ramentable">
          <tr>
              <th class="name">名前</th>
              <th class="mail">Email</th>
              <th class="age">年齢</th>
              <th class="ramen">好きなラーメン</th>
              <th class="topping">好きなトッピング</th>
              <th class="volume">食べる麺量</th>
              <th class="comment">コメント</th>
          </tr>';
    $header = fgetcsv($file);  // ヘッダー行の取得
    // 2行目（データ行）以降を画面表示する
    while($line = fgetcsv($file)) {
        echo "<tr>";
        // 当該行の各項目毎にHTML出力を行う
        for ($i = 1; $i < count($line); $i++){
            switch($i){
                case 1:
                    echo '<td class="name">'.htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8")."</td>";
                    break;
                case 2:
                    echo '<td class="mail">'.htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8")."</td>";
                    break;
                case 3:
                    echo '<td class="age">'.htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8")."</td>";
                    break;
                case 4:
                    echo '<td class="ramen">'.htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8")."</td>";
                    break;
                case 5:
                    echo '<td class="topping">'.htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8")."</td>";
                    break;
                case 6:
                    echo '<td class="volume">'.htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8")."</td>";
                    break;
                case 7:
                    echo '<td class="comment">'.nl2br(htmlspecialchars($line[$i], ENT_QUOTES, "UTF-8"))."</td>";
                    break;
                default:
                    echo "<td></td>";
                    break;
            }
            
            // $ramenData[] = array_combine($header, $line);
        }
        echo "</tr>";
        // $ramenData[] = $line;
        // csvデータを連想配列に格納する。（key：ヘッダー行のタイトル、value：データ行の値）
        $ramenData[] = array_combine($header, $line);
        // 改行コードをエスケープ
        $ramenData = array_map(function($value) {
            return str_replace(["\r\n", "\n"], '\\n', $value);
        }, $ramenData);
    }
    echo "</table></div>";
    fclose($file);
    // var_dump($ramenData);
    $ramenJson = json_encode($ramenData, JSON_UNESCAPED_UNICODE);

?>
<div class="piechart">
    <canvas id="agechart" width="400" height="400"></canvas>
    <canvas id="ramenchart" width="400" height="400"></canvas>
    <canvas id="toppingchart" width="400" height="400"></canvas>
    <canvas id="volumechart" width="400" height="400"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    const ramenJson = JSON.parse('<?=$ramenJson ?>');
    console.log(ramenJson);

    // 年代の集計処理
    const aggregatedAge = {};
    ramenJson.forEach(ramen => {
        console.log("ramen：" + JSON.stringify(ramen));
        if(aggregatedAge[ramen.age]){
            aggregatedAge[ramen.age]++;
        } else {
            aggregatedAge[ramen.age] = 1;
        }
        console.log("aggregatedAge：" + JSON.stringify(aggregatedAge));
    });
    console.log("年代の集計結果：" + JSON.stringify(aggregatedAge));
    // 集計結果をchart.jsに利用するため配列に格納する。
    const ageLabels = Object.keys(aggregatedAge);
    const ageValues = Object.values(aggregatedAge);
    createPie(ageLabels, ageValues, "年代", "agechart");

    // ラーメンの種類の集計処理
    const aggregatedRamen = {};
    ramenJson.forEach(ramen => {
        if(aggregatedRamen[ramen.ramen]){
            aggregatedRamen[ramen.ramen]++;
        } else {
            aggregatedRamen[ramen.ramen] = 1;
        }
    });
    console.log("ラーメンの種類集計結果：" + JSON.stringify(aggregatedRamen));
    // 集計結果をchart.jsに利用するため配列に格納する。
    const ramenLabels = Object.keys(aggregatedRamen);
    const ramenValues = Object.values(aggregatedRamen);
    createPie(ramenLabels, ramenValues, "好きなラーメンの種類", "ramenchart");

    // トッピングの集計処理
    const aggregatedTopping = {};
    ramenJson.forEach(ramen => {
        if(aggregatedTopping[ramen.topping]){
            aggregatedTopping[ramen.topping]++;
        } else {
            aggregatedTopping[ramen.topping] = 1;
        }
    });
    console.log("トッピング集計結果：" + JSON.stringify(aggregatedTopping));
    // 集計結果をchart.jsに利用するため配列に格納する。
    const toppingLabels = Object.keys(aggregatedTopping);
    const toppingValues = Object.values(aggregatedTopping);
    createPie(toppingLabels, toppingValues, "好きなトッピング", "toppingchart");

    // 麺量の集計処理
    const aggregatedVolume = {};
    ramenJson.forEach(ramen => {
        if(aggregatedVolume[ramen.volume]){
            aggregatedVolume[ramen.volume]++;
        } else {
            aggregatedVolume[ramen.volume] = 1;
        }
    });
    console.log("麺量集計結果：" + JSON.stringify(aggregatedVolume));
    // 集計結果をchart.jsに利用するため配列に格納する。
    const volumeLabels = Object.keys(aggregatedVolume);
    const volumeValues = Object.values(aggregatedVolume);
    createPie(volumeLabels, volumeValues, "食べる麺量", "volumechart");

    // chart.jsを使って円グラフ作成処理
    function createPie(labels, values, titleText, idName) {
        // chart.jsに利用する背景色
        const chartColor = [
                "#ffc0cb",
                "#fffacd",
                "#ffff00",
                "#98fb98",
                "#98e6fa",
                "#9898fa",
                "#fa98fa"
            ];

        // chart.js描画
        ctx = document.getElementById(idName).getContext('2d');
        new Chart(ctx, {
            type: 'pie',    // 円グラグを指定
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: chartColor
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: titleText,
                        font: {
                            size: 20,
                            weight: 'bold'
                        },
                        padding: {
                            top: 40,
                            bottom: 10
                        }
                    },
                    datalabels: {
                        color: '#696969',
                        font: {
                            size: 10,
                            weight: 'bold'
                        },
                        formatter: (value, context) => {
                            const chartLabel = context.chart.data.labels[context.dataIndex];
                            return [chartLabel, `${value}票`];
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
</script>
<?php include("inc/foot.html") ?>
</body>
</html>