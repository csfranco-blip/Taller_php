<?php
class Nodo {
    public $valor;
    public $izq;
    public $der;

    public function __construct($valor) {
        $this->valor = $valor;
        $this->izq = null;
        $this->der = null;
    }
}

class ConstructorArbol {
    private $preIndex = 0;

    public function desdePreIn($pre, $in) {
        $this->preIndex = 0;
        $mapaInorden = array_flip($in);
        return $this->construirPreIn($pre, $mapaInorden, 0, count($in) - 1);
    }

    private function construirPreIn($pre, $mapaInorden, $inInicio, $inFin) {
        if ($inInicio > $inFin) return null;

        $valorRaiz = $pre[$this->preIndex++];
        $nodo = new Nodo($valorRaiz);

        if ($inInicio == $inFin) return $nodo;

        $inIndex = $mapaInorden[$valorRaiz];
        $nodo->izq = $this->construirPreIn($pre, $mapaInorden, $inInicio, $inIndex - 1);
        $nodo->der = $this->construirPreIn($pre, $mapaInorden, $inIndex + 1, $inFin);

        return $nodo;
    }

    public function desdeInPost($in, $post) {
        $postIndex = count($post) - 1;
        $mapaInorden = array_flip($in);
        return $this->construirInPost($post, $mapaInorden, 0, count($in) - 1, $postIndex);
    }

    private function construirInPost($post, $mapaInorden, $inInicio, $inFin, &$postIndex) {
        if ($inInicio > $inFin) return null;

        $valorRaiz = $post[$postIndex--];
        $nodo = new Nodo($valorRaiz);

        if ($inInicio == $inFin) return $nodo;

        $inIndex = $mapaInorden[$valorRaiz];
        $nodo->der = $this->construirInPost($post, $mapaInorden, $inIndex + 1, $inFin, $postIndex);
        $nodo->izq = $this->construirInPost($post, $mapaInorden, $inInicio, $inIndex - 1, $postIndex);

        return $nodo;
    }

    public function mostrarArbolHTML($nodo) {
        if ($nodo === null) return "";

        $html = "<li>";
        $html .= "<span class='nodo-valor'>" . htmlspecialchars($nodo->valor) . "</span>";
        
        if ($nodo->izq !== null || $nodo->der !== null) {
            $html .= "<ul>";
            $html .= ($nodo->izq !== null) ? $this->mostrarArbolHTML($nodo->izq) : "<li class='vacio'>[izq: vacío]</li>";
            $html .= ($nodo->der !== null) ? $this->mostrarArbolHTML($nodo->der) : "<li class='vacio'>[der: vacío]</li>";
            $html .= "</ul>";
        }
        
        $html .= "</li>";
        return $html;
    }
}



$error = "";
$metodoUsado = "";
$raiz = null;
$constructor = new ConstructorArbol();

$valPre = $_POST['preorden'] ?? '';
$valIn = $_POST['inorden'] ?? '';
$valPost = $_POST['postorden'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $limpiarEntrada = function($input) {
    if (empty(trim($input))) return [];
    return array_filter(array_map('trim', explode(',', $input)), function($val) {
        return $val !== '';
    });
};


    $preorden  = $limpiarEntrada($valPre);
    $inorden   = $limpiarEntrada($valIn);
    $postorden = $limpiarEntrada($valPost);

    $hayPre   = !empty($preorden);
    $hayIn    = !empty($inorden);
    $hayPost  = !empty($postorden);

    if ($hayPre && $hayIn && $hayPost) {
        $raiz = $constructor->desdePreIn($preorden, $inorden);
        $metodoUsado = "Preorden + Inorden (Por defecto al recibir los 3)";
    } elseif ($hayPre && $hayIn) {
        $raiz = $constructor->desdePreIn($preorden, $inorden);
        $metodoUsado = "Preorden + Inorden";
    } elseif ($hayIn && $hayPost) {
        $raiz = $constructor->desdeInPost($inorden, $postorden);
        $metodoUsado = "Inorden + Postorden";
    } elseif ($hayPre && $hayPost) {
        $error = "No se puede garantizar un árbol único usando únicamente Preorden y Postorden. Por favor ingresa el recorrido Inorden.";
    } else {
        $error = "Debes ingresar al menos dos recorridos válidos para construir el árbol.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constructor de Árboles Binarios</title>
</head>
<body>

<div class="container">

    <a class="volver" href="index.php">volver al menu principal</a> 

    <h2>Construir Árbol Binario</h2> 
    <p>Ingresa al menos dos recorridos separados por comas (Ej: A, B, D, E o 1, 2, 4, 5):</p>

    <form method="POST" action="#">
        
        <div class="form-group">
            <label for="preorden">Recorrido Preorden:</label>
            <input type="text" id="preorden" name="preorden" placeholder="Ej: A, B, D, E, C, F">
        </div>

        <div class="form-group">
            <label for="inorden">Recorrido Inorden:</label>
            <input type="text" id="inorden" name="inorden" placeholder="Ej: D, B, E, A, F, C">
        </div>

        <div class="form-group">
            <label for="postorden">Recorrido Postorden:</label>
            <input type="text" id="postorden" name="postorden" placeholder="Ej: D, E, B, F, C, A">
        </div>

        <button type="submit">Construir Árbol</button>
    </form>
    
    <p class="note">Recuerda que si ingresas los 3, el sistema priorizará Preorden + Inorden</p>
</div>
    <?php if (!empty($error)): ?>
        <div class="alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($raiz !== null): ?>
        <div class="resultado-box">
            <h3>¡Árbol Generado con Éxito!</h3>
            <p><strong>Criterio utilizado:</strong> <?php echo $metodoUsado; ?></p>
            <p>Estructura Jerárquica del Árbol:</p>
            <div class="arbol-visual">
                <ul>
                    <?php echo $constructor->mostrarArbolHTML($raiz); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
