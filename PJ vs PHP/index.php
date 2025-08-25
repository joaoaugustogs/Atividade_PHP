<?php
    $resultado = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $salario_clt = floatval($_POST['salario_clt']);

        if ($salario_clt > 0) {
            
            $decimo_terceiro = $salario_clt / 12; 
            $ferias = ($salario_clt / 12) + (($salario_clt / 12) / 3); 
            $fgts = $salario_clt * 0.08; 
            $inss_empresa = $salario_clt * 0.20; 

            // Benefícios médios (ajuste conforme necessidade)
            $vale_alimentacao = 800; 
            $vale_transporte = 300; 
            $plano_saude = 600; 

            // Custos PJ (simplificados)
            $inss_pj = $salario_clt * 0.11; 
            $ir_pj = $salario_clt * 0.06; // média Simples Nacional
            $contabilidade = 400; 

            // Soma de todos os custos que o PJ precisa cobrir
            $custos_adicionais = $decimo_terceiro + $ferias + $fgts + $inss_empresa 
                                + $vale_alimentacao + $vale_transporte + $plano_saude
                                + $inss_pj + $ir_pj + $contabilidade;

            // Salário PJ equivalente
            $salario_pj = $salario_clt + $custos_adicionais;

            $resultado = "Para um salário CLT de R$ " . number_format($salario_clt, 2, ',', '.') . 
                         " o equivalente PJ seria de aproximadamente R$ " . number_format($salario_pj, 2, ',', '.');
        } else {
            $resultado = "Digite um valor válido.";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Calculadora PJ vs CLT</title>
</head>
<body>

    <h1>Calculadora de Salário PJ vs. CLT</h1>

    <form method="post">
        <label>Salário Bruto CLT Desejado:</label><br>
        <input type="number" step="0.01" name="salario_clt" required><br><br>
        <input type="submit" value="Calcular">
    </form>

    <?php if (!empty($resultado)): ?>
        <h2><?php echo $resultado; ?></h2>
    <?php endif; ?>

</body>
</html>
