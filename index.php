<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include("inc/head.html") ?>
    <title>ラーメンアンケート</title>
</head>
<body>
    <?php include("inc/header.html") ?>
    <div class="container">
        <form action="write.php" method="post" class="ramenform">
            名前：<br><input type="text" name="name" class="formtext"><br>
            Email：<br><input type="text" name="email" class="formtext"><br>
            年齢：
            <div class="formselect">
                <select name="age">
                    <option value="10">10代</option>
                    <option value="20">20代</option>
                    <option value="30">30代</option>
                    <option value="40">40代</option>
                    <option value="50">50代</option>
                    <option value="60">60代</option>
                    <option value="70">70代</option>
                </select>
            </div>
            好きなラーメン：
            <div class="formselect">
                <select name="ramen">
                    <option value="soy">醤油</option>
                    <option value="salt">塩</option>
                    <option value="miso">味噌</option>
                    <option value="seafood">魚介系</option>
                    <option value="jiro">二郎系</option>
                    <option value="house">家系</option>
                    <option value="pork">とんこつ</option>
                </select>
            </div>
            好きなトッピング：
            <div class="formselect">
                <select name="topping">
                    <option value="egg">卵</option>
                    <option value="seaweed">海苔</option>
                    <option value="garlic">にんにく</option>
                    <option value="roastpork">チャーシュー</option>
                    <option value="vegetable">野菜</option>
                    <option value="ginger">しょうが</option>
                    <option value="fat">脂</option>
                </select>
            </div>
            食べる麺量：
            <div class="formselect">
                <select name="volume">
                    <option value="100">100g台</option>
                    <option value="200">200g台</option>
                    <option value="300">300g台</option>
                    <option value="400">400g台</option>
                    <option value="more500">500g以上</option>
                </select>
            </div>
            コメント：<textarea name="memo" class="formtextarea"></textarea><br>
            <button type="submit" class="formbutton">送信</button>
        </form>
    </div>
    
    <?php include("inc/foot.html") ?>
</body>
</html>