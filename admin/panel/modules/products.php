

<!-- ================ Order Details List ================= -->
<div class="details" style="display: flex;">
    <div class="recentOrders" style="width:100%;display: flex;
    flex-direction: column;">
    <div class="cardHeader">
        <h2>Listado de Productos</h2>
        <a href="?mod=newproduct" class="btn">Crear Nuevo</a>
    </div>

    <table>
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Código</td>
                <td>Tipo</td>
                <td>Tags</td>
                <td>Medidas</td>
                <td>Descripción</td>
                <td>Stock</td>
                <td>Precio</td>
                <td>Foto</td>
                <td>Fecha de Creación</td>
                <td>Acciones</td>
            </tr>
        </thead>

        <tbody>
            <?php  
            $products = $conn->query("SELECT * from products order by id desc");
            if($products->num_rows>0){ 
                while($p = $products->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo html_entity_decode(utf8_decode($p['name']??""), ENT_QUOTES, "UTF-8"); ?></td>
                        <td><?php echo $p['cod'] ?></td>
                        <td><?php echo $p['type'] ?></td>
                        <td><?php echo $p['tags'] ?></t d>
                        <td><?php echo html_entity_decode(utf8_decode($p['medidas']), ENT_QUOTES, "UTF-8"); ?></td>
                        <td><?php echo html_entity_decode(utf8_decode($p['description']??""), ENT_QUOTES, "UTF-8"); ?></td>
                        <td><?php echo $p['stock'] ?> / Unidades</td>
                        <td><?php echo '€ '.$p['price'] ?></td>
                        <td>
                            <img src="../../assets/img/products/<?php echo $p['photo'] ?>" width="120px" height="120px" style="border-radius: 25px;" />
                        </td>
                        <td><?php echo formatDate($p['created_at']); ?></td>
                        <td>
                            <a href="../components/deleteProduct.php?prodId=<?php echo $p['id']; ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php    }else{
                echo '<tr>
                <td>No hay productos disponibles aún.</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>';
            }
            ?>
            
        </tbody>
    </table>
</div>
</div>
<style>
    .btn{
        padding:5px 10px;
        border-radius:5px;
    }
    .btn-danger{
        box-shadow: 0 0 5px red;
        background:#f119;
        color:#fff;
    }
    .btn-danger:hover{
        color:#fff;
        background:#f11e;
    }
</style>