<?php
    $resultado = "";

    // array associativo de moedas
    $moedas = [
        "Dólar" => 5.45,
        "Euro" => 6.32,
        "Libra" => 7.35,
        "Peso Argentino" => 0.05
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['converter'])) {
        $valor = (float)$_POST['valor'];
        $moeda = $_POST['moeda'];
        $cotacao = $moedas[$moeda];

        $convertido = $valor / $cotacao;
        $resultado = "R$ " . number_format($valor,2,",",".") . " equivalem a " 
                     . number_format($convertido,2,",",".") . " $moeda(s).";
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Conversão de Moeda</title>
</head>
<body>
    <h1>Conversão de Moeda</h1>
    <form method="post">
        <label>Valor em Reais:</label>
        <input type="number" step="0.01" name="valor" required><br><br>

        <label>Moeda:</label>
        <select name="moeda">
            <?php foreach ($moedas as $nome => $c): ?>
                <option value="<?= $nome ?>"><?= $nome ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" name="converter" value="Converter">
    </form>

    <?php if (!empty($resultado)): ?>
        <h2><?= $resultado ?></h2>
    <?php endif; ?>
</body>
</html>
