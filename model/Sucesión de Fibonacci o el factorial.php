<?php

$numero = "";
$opcion = "";
$resultado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (isset($_POST['numero']) && $_POST['numero'] !== "") {
        $numero = (int)$_POST['numero'];
        $opcion = $_POST['opciones'];

        if ($numero >= 0) {
            if ($opcion === "fibonacci") {
                $inicio = 0;
                $actual = 1;
                $serie_fib = [];

                for ($i = 0; $i < $numero; $i++) {
                    $serie_fib[] = $inicio;
                    $siguiente = $inicio + $actual;
                    $inicio = $actual;
                    $actual = $siguiente;
                }
                
                $resultado = implode(", ", $serie_fib);

            } elseif ($opcion === "factorial") {
                
                if ($numero === 0) {
                    $resultado = "0! = 1";
                } else {
                    $serie_fact = [];
                    $acumulado = 1;
                    for ($i = 1; $i <= $numero; $i++) {
                        $acumulado *= $i;
                        $serie_fact[] = $acumulado;
                    }
                    $resultado = implode(", ", $serie_fact);
                }
            }
        } else {
            $resultado = "Por favor, ingrese un número entero positivo.";
        }
    } else {
        $resultado = "El campo del número no puede estar vacío.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular Sucesión o Factorial</title>
</head>
<body>

    <a class="volver" href="index.php">Volver al menú principal</a>

    <form method="POST" action="sucecion de fibonacci o factorial.php">
        <div class="form-group">
            <label Lothar for="numero">Ingrese un número entero positivo:</label><br>
            <input type="number" id="numero" name="numero" min="0" value="<?php echo htmlspecialchars($numero); ?>" required>
        </div>

        <div class="form-group">
            <label for="opciones">Elige una opción:</label><br>
            <select id="opciones" name="opciones">
             
                <option value="factorial" <?php echo ($opcion == 'factorial') ? 'selected' : ''; ?>>Factorial</option>
                <option value="fibonacci" <?php echo ($opcion == 'fibonacci') ? 'selected' : ''; ?>>Sucesión de Fibonacci</option>
            </select> 
        </div>

        <button type="submit">Calcular</button>
    </form>

    <?php if (!empty($resultado)): ?>
    <div class="resultado">
        <p>El resultado de la serie es:</p><br>
        <?php echo htmlspecialchars($resultado); ?>
    </div>
    <?php endif; ?>

</body>
</html>
