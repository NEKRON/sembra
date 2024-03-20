<?php
$clientes = $conn->query("SELECT * from clientes ORDER BY id desc");
?>

<!-- ================ Order Details List ================= -->
<div class="details" style="display: flex;">
  <div class="recentOrders" style="width:100%;display: flex;
    flex-direction: column;">
    <div class="cardHeader">
      <h2>Listado de Clientes</h2>
    </div>

    <table>
      <thead>
        <tr>
          <td style="white-space:nowrap;">#Cliente ID</td>
          <td style="white-space:nowrap;">Nombre</td>
          <td style="white-space:nowrap;">Documento</td>
          <td style="white-space:nowrap;">Teléfono</td>
          <td style="white-space:nowrap;">Email</td>
          <td style="white-space:nowrap;">Dirección</td>
          <td style="white-space:nowrap;">Fecha de Creación</td>
        </tr>
      </thead>

      <tbody>
        <?php
        if ($clientes->num_rows > 0) {

          while ($c = $clientes->fetch_assoc()) {
            ?>
            <tr style="background:#9991" class="hover-tr">
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo $c['client_id'] ?? ''; ?>
              </td>
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo html_entity_decode(utf8_decode($c['nombre'] ?? ''), ENT_QUOTES, "UTF-8"); ?>
              </td>
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo $c['documento'] ?? ''; ?>
              </td>
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo $c['telefono'] ?? ''; ?>
              </td>
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo $c['email'] ?? ''; ?>
              </td>
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo html_entity_decode(utf8_decode($c['direccion'] ?? ''), ENT_QUOTES, "UTF-8"); ?>
              </td>
              <td style="color:#222 !important; white-space:nowrap;">
                <?php echo formatDate($c['created_at'] ?? ''); ?>
              </td>
            </tr>
          <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
<style>
  .btn {
    padding: 5px 10px;
    border-radius: 5px;
  }

  .btn-danger {
    box-shadow: 0 0 5px red;
    background: #f119;
    color: #fff;
  }

  .btn-danger:hover {
    color: #fff;
    background: #f11e;
  }

  .hover-tr:hover{
    background:#2221 !important;
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
        try {
          const response = await fetch("../components/deleteOrderById.php", {
            method: "POST",
            body: JSON.stringify({
              order_id: orderId
            })
          });

          if (!response.ok) {
            throw ("Error de red.");
          }

          const resp = await response.json();

          if (!resp.success) {
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
        } catch (e) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al eliminar el pedido: ' + e,
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