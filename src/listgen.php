<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>リストジェネレータ</title>
</head>
<body>
    <h1>リストジェネレータ</h1>
    <form action="listgen.php" method="POST">
        <label for="F">F:</label>
        <input type="text" id="F" name="F"><br>
        <label for="E">E:</label>
        <input type="text" id="E" name="E" required><br>
        <label for="S">S:</label>
        <input type="text" id="S" name="S"><br>
        <label for="Pre">Pre:</label>
        <input type="text" id="Pre" name="Pre"><br>
        <label for="Post">Post:</label>
        <input type="text" id="Post" name="Post"><br>
        <input type="submit" value="送信">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $F = isset($_POST["F"]) && is_numeric($_POST["F"]) ? (int)$_POST["F"] : 0;
        $E = isset($_POST["E"]) && is_numeric($_POST["E"]) ? (int)$_POST["E"] : null;
        $S = isset($_POST["S"]) && is_numeric($_POST["S"]) ? (int)$_POST["S"] : 1;
        $Pre = htmlspecialchars($_POST["Pre"]);
        $Post = htmlspecialchars($_POST["Post"]);

        if ($E === null) {
            echo "エラー: Eを入力してください。<br>";
        } else {
            if ($F >= $E || $S <= 0) {
                echo "エラー: 入力値が不正です。<br>";
            } else {
                for ($i = $F; $i < $E; $i += $S) {
                    echo $Pre . $i . $Post . "<br>";
                }
            }
        }
    }
    ?>
</body>
</html>
