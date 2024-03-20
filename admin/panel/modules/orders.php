<?php 
 $ventas = $conn->query("SELECT * from ventas as v inner join clientes as c on v.client_id=c.client_id order by v.id desc");
?>

<!-- ================ Order Details List ================= -->
<div class="details" style="display: flex;">
    <div class="recentOrders" style="width:100%;display: flex;
    flex-direction: column;">
    <div class="cardHeader">
        <h2>Listado de Pedidos</h2>
    </div>

    <table>
                <thead>
                    <tr>
                        <td style="white-space:nowrap;">Orden ID</td>
                        <td style="white-space:nowrap;">Cliente</td>
                        <td style="white-space:nowrap;"># ID Cliente</td>
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
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo $v["client_id"]; ?></td>
                        
                        <td style="color:#222 !important; white-space:nowrap;">€ <?php echo $precio ?></td>
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo $v['quantity'] ?></td>
                        <td style="color:#222 !important; white-space:nowrap;"><span class="status <?php echo $v['status']; ?>"><?php echo $estado; ?></span></td>
                        <td style="color:#222 !important; white-space:nowrap;"><?php echo formatDate($v['created_at']); ?></td>
                        <td style="color:#222 !important; white-space:nowrap;">
                            <a href="?mod=detailsOrder&id=<?php echo $v['order_id']??''; ?>" class="btn btn-info" style="background:lightblue;box-shadow: 0 0 5px lightblue;color:#000;">
                              Ver detalles
                            </a>
                            <a href="javascript:;" order-id="<?php echo $v["order_id"]; ?>" onclick="deleteOrder(this)" class="btn btn-danger" style="margin-left:10px;">
                              Eliminar pedido
                            </a>
                        </td>
                    </tr>
                <?php }
                } ?>
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
<script>
  const deleteOrder = async (element) => {
    const orderId = element.getAttribute("order-id");
    Swal.fire({
        title: 'Confirmar eliminación',
        text: '¿Estás seguro de que quieres eliminar este pedido?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!',
        cancelButtonText: 'No, cancelar!',
    }).then(async (result) => {
        if (result.isConfirmed) {
          try{
            const response = await fetch("../components/deleteOrderById.php", {
              method : "POST",
              body : JSON.stringify({
                order_id : orderId
              })
            });

            if(!response.ok){
              throw("Error de red.");
            }

            const resp = await response.json();

            if(!resp.success){
              throw (resp.message);
            }

            const rowToDelete = element.closest('tr');
            
            if (rowToDelete) {
              rowToDelete.remove();
            }

            Swal.fire({
                icon: 'success',
                title: 'Listo!',
                text: 'Eliminaste este pedido correctamente.',
            });
          }catch(e){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al eliminar el pedido: '+e,
            });
          }
        }
    }).catch((error) => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un problema al eliminar la orden. Por favor, inténtalo de nuevo.',
        });
    });
  };
</script>