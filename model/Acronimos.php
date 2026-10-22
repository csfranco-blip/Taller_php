<?php
$frase_usuario = "";
$resultado_acronimo = "";


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['frase'])) {
    $frase_usuario = $_POST['frase'];
    

    $fraseLimpia = str_replace('-', ' ', $frase_usuario);
    $palabras = preg_split('/\s+/', trim($fraseLimpia));
    
    foreach ($palabras as $palabra) {
        if (!empty($palabra)) {
            $primeraLetra = mb_substr($palabra, 0, 1, 'UTF-8');
            $resultado_acronimo .= mb_strtoupper($primeraLetra, 'UTF-8');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>generador de Acronimos</title>
</head>
<body>
    <a class="volver"href="index.php">volver al menu principal</a>
    <form method="POST"action="Acronimos.php">
        <div>
        <label for="frase">ingrese la frase o texto largo</label><br>
        <input type="text" id="frase" name="frase" value="<?php echo htmlspecialchars($frase_usuario); ?>">
        <button type="submit">generar Acronimo</button>
        </div>
    </form>
    <?php 
   if (!empty($resultado_acronimo)): ?>
        <div class="resultado">
            <p>El acrónimo es:</p> <?php echo $resultado_acronimo; ?>
        </div>
    <?php endif;
    ?>
</body>
</html>