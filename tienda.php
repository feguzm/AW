<?php 
$tituloPagina = 'Tienda';

require_once './includes/config.php';
require RUTA_VISTAS . 'plantillas/plantilla2.php';
require_once RUTA_INCLUDES . 'formulariobuscar.php';
require_once RUTA_INCLUDES . 'formulariounidadescarrito.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start();
?>

<main>
    <h2>Nuestros Productos</h2>
    
    <div class="busqueda-container">
        <?php
        $form = new formulariobuscar();
        $htmlFormBuscar = $form->gestiona();
        ?>
        <?=$htmlFormBuscar?>
    </div>

    <div class="productos-container">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
			<img src="<?php echo RUTA_IMGS . 'productos/' . (!empty($producto->getImagen()) ? $producto->getImagen() : 'default.png'); ?>" 
                         alt="<?php echo htmlspecialchars($producto->getNombre()); ?>">
                    <h3><?php echo ucfirst(htmlspecialchars($producto->getNombre())); ?></h3>
                    <p class="precio">$<?php echo number_format($producto->getPrecio(), 2); ?></p>
                    <p class="stock">Stock disponible: <?php echo $producto->getStock(); ?></p>
                    
                    <a href="controller.php?controller=detalle&action=mostrarDetalle&id=<?php echo $producto->getIdProducto(); ?>" class="btn">Ver detalles</a>

                    <?php if (!(isset($_SESSION['rol']) && $_SESSION['rol'] == 'vendedor')): ?>
		    <?php
                    $form = new formulariounidadescarrito($producto->getIdProducto());                   
                    $htmlFormUdsCarrito = $form->gestiona();
                    ?> 
                    <?= $htmlFormUdsCarrito ?>
		    <?php endif;?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos disponibles en este momento.</p>
        <?php endif; ?>
    </div>
</main>