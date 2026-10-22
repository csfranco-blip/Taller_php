<?php
$errores = "";
$resultados = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $entrada = isset($_POST['numeros']) ? trim($_POST['numeros']) : '';

    if (empty($entrada)) {
        $errores = "Por favor, ingrese al menos un número.";
    } else {
      
        $partes = explode(',', $entrada);
        $numeros = [];

        
        foreach ($partes as $parte) {
            $parte_limpia = trim($parte);
            if ($parte_limpia !== "") {
                if (is_numeric($parte_limpia)) {
                    $numeros[] = (float)$parte_limpia;
                } else {
                    $errores = "El valor '$parte_limpia' no es un número real válido.";
                    break;
                }
            }
        }

        $cantidad = count($numeros);

        if ($cantidad === 0 && empty($errores)) {
            $errores = "Debe ingresar una serie de números separados por comas.";
        }

       
        if (empty($errores)) {
            $promedio = array_sum($numeros) / $cantidad;

            $numeros_ordenados = $numeros;
            sort($numeros_ordenados);
            $mitad = floor($cantidad / 2);

            if ($cantidad % 2 == 0) {
    
                $mediana = ($numeros_ordenados[$mitad - 1] + $numeros_ordenados[$mitad]) / 2;
            } else {
                $mediana = $numeros_ordenados[$mitad];
            }

    
            $valores_frecuentes = array_count_values(array_map('strval', $numeros));
            $max_frecuencia = max($valores_frecuentes);

            if ($max_frecuencia === 1 && $cantidad > 1) {
                $moda_texto = "No hay moda (todos los valores son únicos)";
            } else {
                $modas = array_keys($valores_frecuentes, $max_frecuencia);
                $moda_texto = implode(', ', $modas);
            }

            $resultados = [
                'cantidad' => $cantidad,
                'promedio' => round($promedio, 4),
                'mediana'  => round($mediana, 4),
                'moda'     => $moda_texto
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>saca promedio, mediana y moda</title>
</head>
<body>
     <a class="volver" href="index.php">Volver al menú principal</a>

   <form method="POST" action="#">
        <label for="numeros">Ingrese números reales (separados por comas):</label>
        <input type="text" id="numeros" name="numeros" 
                ="Ej: 12.5, 7.8, 22, 7.8, 5.1" 
               value="<?php echo isset($_POST['numeros']) ? htmlspecialchars($_POST['numeros']) : ''; ?>">
        <button type="submit">Calcular</button>
    </form>

    <?php if ($resultados !== null): ?>
        <div class="resultados">
            <h3>Resultados</h3>
            <p>Cantidad de números:<?php echo $resultados['cantidad']; ?></p>
            <p>Promedio (Media): <?php echo $resultados['promedio']; ?></p>
            <p>Mediana: <?php echo $resultados['mediana']; ?></p>
            <p>Moda: <?php echo $resultados['moda']; ?></p>
        </div>
    <?php endif; ?>
</body>
</html>