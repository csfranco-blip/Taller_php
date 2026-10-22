<?php 
session_start();

$pantalla = isset($_POST['pantalla']) ? $_POST['pantalla'] : '';

if (!isset($_SESSION['historial'])) {
    $_SESSION['historial'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'C') {
            $pantalla = '';
        } elseif ($accion === 'borrar_historial') {
            $_SESSION['historial'] = [];
        } elseif ($accion === '=') {
            if (!empty($pantalla)) {
                $expresion_php = str_replace('%', '*0.01', $pantalla);

                try {
                    if (preg_match('/^[0-9.+\-*\/]*$/', $expresion_php)) {
                        $resultado = eval("return ($expresion_php);");
                        
                        if ($resultado !== false && $resultado !== null) {
                            $_SESSION['historial'][] = $pantalla . " = " . $resultado;
                            $pantalla = $resultado;
                        } else {
                            $pantalla = 'Error';
                        }
                    } else {
                        $pantalla = 'Error';
                    }
                } catch (Throwable $e) {
                    $pantalla = 'Error';
                }
            }
        } else {
            if ($pantalla === 'Error') {
                $pantalla = '';
            }
            $pantalla .= $accion;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcuradora</title>
</head>
<body>
    
    <a class="volver"href="index.php">volver al menu principal</a>

<div class="container">
    <form method="POST" class="calculator">
        <input type="text" class="display-input" name="pantalla" value="<?php echo htmlspecialchars($pantalla); ?>" readonly>
        
        <div class="buttons">
            <button type="submit" name="accion" value="C">C</button>
            <button type="submit" name="accion" value="%" class="operator">%</button>
            <button type="submit" name="accion" value="/" class="operator">/</button>
            <button type="submit" name="accion" value="*" class="operator">*</button>
            
            <button type="submit" name="accion" value="7">7</button>
            <button type="submit" name="accion" value="8">8</button>
            <button type="submit" name="accion" value="9">9</button>
            <button type="submit" name="accion" value="-" class="operator">-</button>
            
            <button type="submit" name="accion" value="4">4</button>
            <button type="submit" name="accion" value="5">5</button>
            <button type="submit" name="accion" value="6">6</button>
            <button type="submit" name="accion" value="+" class="operator">+</button>
            
            <button type="submit" name="accion" value="1">1</button>
            <button type="submit" name="accion" value="2">2</button>
            <button type="submit" name="accion" value="3">3</button>
            <button type="submit" name="accion" value="=" class="operator">=</button>
            
            <button type="submit" name="accion" value="0">0</button>
            <button type="submit" name="accion" value=".">.</button>
        </div>
    </form>

       <div class="history-box">
        <h3>Historial</h3>
        <ul class="history-list">
            <?php if (!empty($_SESSION['historial'])): ?>
                <?php foreach ($_SESSION['historial'] as $operacion): ?>
                    <li><?php echo htmlspecialchars($operacion); ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No hay operaciones</li>
            <?php endif; ?>
        </ul>
        
        <form method="POST">
            <button type="submit" name="accion" value="borrar_historial" class="clear-btn">Borrar Historial</button>
        </form>
    </div>
</div>
</body>
</html>