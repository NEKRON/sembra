
<?php 

                $ventas = $conn->query("SELECT * from ventas as v inner join clientes as c on v.client_id=c.client_id order by v.id desc limit 7");

                $productos = $conn->query("SELECT id from products");
                 ?>

<!-- ======================= Cards ================== -->
<div class="cardBox">
    <a class="card" href="?mod=products">
        <div>
            <div class="numbers"><?php echo $productos->num_rows; ?></div>
            <div class="cardName">Productos Totales <?php echo $ventas->num_rows; ?></div>
        </div>

        <div class="iconBx">
            <ion-icon name="cart-outline"></ion-icon>
        </div>
    </a>

    <a href="?mod=orders" class="card">
        <div>
            <div class="numbers"><?php echo $ventas->num_rows; ?></div>
            <div class="cardName">Ventas</div>
        </div>

        <div class="iconBx">
            <ion-icon name="cart-outline"></ion-icon>
        </div>
    </a>

    <a href="?mod=clients" class="card">
        <?php 
            $clientsNum = $conn->query("SELECT DISTINCTROW(client_id) from clientes order by id desc");
        ?>
        <div>
            <div class="numbers"><?php echo $clientsNum->num_rows; ?></div>
            <div class="cardName">Clientes</div>
        </div>

        <div class="iconBx">
            <i class="ri-account-box-line"></i>
        </div>
    </a>

    <div class="card">
        <div>
            <div class="numbers">0</div>
            <div class="cardName">Publicaciones</div>
        </div>

        <div class="iconBx">
            <ion-icon name="folder-outline"></ion-icon>
        </div>
    </div>
</div>

<!-- ================ Order Details List ================= -->
<div class="details" style="display:flex;flex-wrap:wrap;">
    <div class="recentOrders" style="min-height:100px;flex:1;">
        <div style="width:100%;display:flex;flex-direction:column;gap:10px;justify-content:initial;">
        <div class="cardHeader" style="max-height:40px;">
                <h2>Ordenes Recientes</h2>
                <a href="?mod=orders" class="btn">Ver todo</a> 
            </div>

            <table>
                <thead>
                    <tr>
                        <td style="white-space:nowrap;">Orden ID</td>
                        <td style="white-space:nowrap;">Cliente</td>
                        <td style="white-space:nowrap;">Precio x/unidad</td>
                        <td style="white-space:nowrap;">Cantidad</td>
                        <td style="white-space:nowrap;">Estado</td>
                        <td style="white-space:nowrap;">Fecha</td>
                        <td style="white-space:nowrap;">Acciones</td>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    if($ventas->num_rows>0){ 

                        while($v = $ventas->fetch_assoc()){

                            $precio = $v['prod_id'];
                            $precio = $conn->query("SELECT price from products where id='$precio'");
                            if($precio->num_rows>0){
                                $precio = $precio->fetch_assoc();
                                $precio = $precio['price'];
                            }else{
                                $precio = '';
                            }

                            $estado = $v["status"]??"";

                            switch($v["status"]){
                                case "pending" : $estado = "Pendiente"; break;
                                case "preparing" : $estado = "Preparando"; break;
                                case "incoming" : $estado = "En Camino"; break;
                                case "delivered" : $estado = "Entregado"; break;
                            };

                        ?>
                    <tr style="background:#9991 !important;">
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo $v['order_id']??''; ?></td>
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo html_entity_decode(utf8_decode($v['nombre']??''), ENT_QUOTES, "UTF-8"); ?></td>
                        <td style="color:#222 !important; white-space:nowrap;">€ <?php echo $precio ?></td>
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo $v['quantity'] ?></td>
                        <td style="color:#222 !important; white-space:nowrap;"><span class="status <?php echo $v['status']; ?>"><?php echo $estado; ?></span></td>
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo formatDate($v['created_at']); ?></td>
                        <td style="color:#222 !important; white-space:nowrap;">
                            <a href="?mod=detailsOrder&id=<?php echo $v['order_id']??''; ?>" style="color:#66f;text-decoration:underline;cursor:pointer;white-space:nowrap;">Ver detalles</a>
                        </td>
                    </tr>
                <?php }
                } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= New Customers ================ -->
    <div class="recentCustomers" style="min-height: 100px;flex:1;min-width:250px;">
        <div class="cardHeader">
            <h2>Compradores Recientes</h2>
        </div>

        <table>
            <?php 
                $clientes = $conn->query("SELECT * from clientes order by id desc limit 7");
                if($clientes->num_rows>0){ 

                    while($c = $clientes->fetch_assoc()){
                    ?>
                    <tr>
                        <td>
                            <h4><?php echo $c['nombre'] ?> <br> <span><?php echo $c['email']; ?></span></h4>
                        </td>
                    </tr>
                <?php } ?>
        <?php   }else {
                    ?>
                    <tr>
                        <td>
                            <h4>Sin datos.</h4>
                        </td>
                    </tr>
                    <?php
                }
            ?>
                    
        </table>
    </div>
</div>
<style>
</style>