<?php
    $resultado = "";
    $detalhes = "";

    // Funções para cálculo dos impostos
    function calcularICMS($valor) {
        return $valor * 0.18;
    }

    function calcularIPI($valor) {
        return $valor * 0.10;
    }

    function calcularISS($valor) {
        return $valor * 0.05;
    }

    function calcularPISCOFINS($valor, $regime = "cumulativo") {
        if ($regime === "cumulativo") {
            $pis = $valor * 0.0065;
            $cofins = $valor * 0.03;
        } else {
            $pis = $valor * 0.0165;
            $cofins = $valor * 0.076;
        }
        return $pis + $cofins;
    }

    // Se o formulário for enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $valor = (float)$_POST['valor'];
        $tipo = $_POST['tipo'];
        $regime = $_POST['regime'];

        $total_impostos = 0;
        $detalhes .= "<h3>Detalhes dos Impostos:</h3><ul>";

        // ICMS (aplica sempre)
        $icms = calcularICMS($valor);
        $total_impostos += $icms;
        $detalhes .= "<li>ICMS: R$ " . number_format($icms,2,",",".") . "</li>";

        // IPI (só para produto)
        if ($tipo === "produto") {
            $ipi = calcularIPI($valor);
            $total_impostos += $ipi;
            $detalhes .= "<li>IPI: R$ " . number_format($ipi,2,",",".") . "</li>";
        }

        // ISS (só para serviço)
        if ($tipo === "servico") {
            $iss = calcularISS($valor);
            $total_impostos += $iss;
            $detalhes .= "<li>ISS: R$ " . number_format($iss,2,",",".") . "</li>";
        }

        // PIS/COFINS (sempre)
        $piscofins = calcularPISCOFINS($valor, $regime);
        $total_impostos += $piscofins;
        $detalhes .= "<li>PIS/COFINS: R$ " . number_format($piscofins,2,",",".") . "</li>";

        $detalhes .= "</ul>";

        $preco_final = $valor + $total_impostos;

        $resultado = "Produto/Serviço: $nome<br>"
                   . "Valor Base: R$ " . number_format($valor,2,",",".") . "<br>"
                   . "Total de Impostos: R$ " . number_format($total_impostos,2,",",".") . "<br>"
                   . "<strong>Preço Final: R$ " . number_format($preco_final,2,",",".") . "</strong>";
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Impostos</title>
</head>
<body>
    <h1>Calculadora de Impostos</h1>

    <form method="post">
        <label>Nome do Produto/Serviço:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Valor (R$):</label><br>
        <input type="number" step="0.01" name="valor" required><br><br>

        <label>Tipo:</label><br>
        <select name="tipo">
            <option value="produto">Produto</option>
            <option value="servico">Serviço</option>
        </select><br><br>

        <label>Regime PIS/COFINS:</label><br>
        <select name="regime">
            <option value="cumulativo">Cumulativo (0,65% + 3%)</option>
            <option value="nao-cumulativo">Não-Cumulativo (1,65% + 7,6%)</option>
        </select><br><br>

        <input type="submit" value="Calcular">
    </form>

    <?php if (!empty($resultado)): ?>
        <h2>Resultado:</h2>
        <p><?= $resultado ?></p>
        <?= $detalhes ?>
    <?php endif; ?>
</body>
</html>
