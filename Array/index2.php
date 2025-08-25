<?php
    $resultado = "";

    // array de frutas com preço por kg
    $frutas = [
        "Maçã" => 7.50,
        "Banana" => 5.20,
        "Melancia" => 4.00,
        "Uva" => 12.00,
        "Manga" => 8.90
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {
        $fruta = $_POST['fruta'];
        $kg = (float)$_POST['kg'];
        $preco = $frutas[$fruta];

        $total = $kg * $preco;

        // aplica desconto se passar de 30
        if ($total > 30) {
            $desconto = $total * 0.12;
            $total -= $desconto;
            $resultado = "Você comprou $kg Kg de $fruta. Valor com desconto de 12%: R$ " . number_format($total,2,",",".");
        } else {
            $resultado = "Você comprou $kg Kg de $fruta. Valor total: R$ " . number_format($total,2,",",".");
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Balança Digital</title>
</head>
<body>
    <h1>Balança Digital</h1>
    <form method="post">
        <label>Fruta:</label>
        <select name="fruta">
            <?php foreach ($frutas as $nome => $preco): ?>
                <option value="<?= $nome ?>"><?= $nome ?> (R$ <?= number_format($preco,2,",",".") ?>/Kg)</option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Quantidade (Kg):</label>
        <input type="number" step="0.01" name="kg" required><br><br>

        <input type="submit" name="calcular" value="Calcular">
    </form>

    <?php if (!empty($resultado)): ?>
        <h2><?= $resultado ?></h2>
    <?php endif; ?>
</body>
</html>
