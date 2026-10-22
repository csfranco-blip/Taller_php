<?php
$numero_entero ="";
$numero_binario = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
     if (isset($_POST['convertir'])) {
        $numero_entero = intval($_POST['convertir']);
          if ($numero_entero === 0) {
            $numero_binario = "0"; 
        } else {
            $temporal = $numero_entero; 
            $residuo_acumulado = "";

            while ($temporal > 0) {
                $residuo = $temporal % 2;          
                $residuo_acumulado = $residuo . $residuo_acumulado; 
                $temporal = intdiv($temporal, 2);  
            }

            $numero_binario = $residuo_acumulado;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>conversión de nuemeros enteros a bianarios</title>
</head>
<body>

     <a class="volver" href="index.php">Volver al menú principal</a>

    <form method="POST" action="#">
        <div>
        <label for="convertir">Ingerse un numero entero para convertirlo en bianario</label>
        <input type="number" name="convertir" id="convertir" value="<?php echo htmlspecialchars($numero); ?>" required>
        <button type="submit">convertir</button>
        </div>
        </div>
    </form>
    <?php
        if($numero_binario !== NULL):?>
        <div class="resultado">
            <p>resultado:</p><?php echo $numero_binario;?>
        </div>
     <?php  endif; ?>
</body>
</html>