<?php
$inputA = "";
$inputB = "";
$resultados = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputA = $_POST['conjuntoA'] ?? '';
    $inputB = $_POST['conjuntoB'] ?? '';

    $procesarConjunto = function($cadena) {
        if (trim($cadena) === "") return [];
        $elementos = explode(",", $cadena);
        $filtrados = array_map('intval', array_map('trim', $elementos));
        return array_unique($filtrados);
    };

    $A = $procesarConjunto($inputA);
    $B = $procesarConjunto($inputB);

    $resultados = [
        'A' => $A,
        'B' => $B,
        'union' => array_unique(array_merge($A, $B)),
        'interseccion' => array_intersect($A, $B),
        'diffAB' => array_diff($A, $B),
        'diffBA' => array_diff($B, $A)
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones entre conjuntos</title>
</head>
<body>
 <a class="volver" href="index.php">Volver al menú principal</a>

 <form method="POST" action="#">
    <div class="campo">
        <label museums for="conjuntoA">Ingrese el Conjunto A (enteros separados por comas):</label>
        <input type="text" id="conjuntoA" name="conjuntoA" value="<?php echo htmlspecialchars($inputA); ?>" placeholder="Ej: 1, 2, 3, 4" required> 
    </div>

    <div class="campo">
        <label for="conjuntoB">Ingrese el Conjunto B (enteros separados por comas):</label>
        <input type="text" id="conjuntoB" name="conjuntoB" value="<?php echo htmlspecialchars($inputB); ?>" placeholder="Ej: 3, 4, 5, 6" required> 
    </div>

    <button type="submit">Calcular Operaciones</button>
 </form>

 <?php if ($resultados !== null): ?>
    <div class="resultados">
        <h3>Resultados:</h3>
        <p>Conjunto A:[<?php echo implode(", ", $resultados['A']); ?>]</p>
        <p>Conjunto B:[<?php echo implode(", ", $resultados['B']); ?>]</p>
        <hr>
        <p>Unión (A ∪ B):[<?php echo implode(", ", $resultados['interseccion']); ?>]</p>
        <p>Diferencia (A - B):[<?php echo implode(", ", $resultados['diffAB']); ?>]</p>
        <p>Diferencia (B - A):[<?php echo implode(", ", $resultados['diffBA']); ?>]</p>
    </div>
 <?php endif; ?>

</body>
</html>
