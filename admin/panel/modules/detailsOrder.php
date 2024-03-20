<?php
$oid = $_REQUEST["id"] ?? '';
$v = $conn->query("SELECT * FROM ventas as v INNER JOIN clientes as c on v.client_id = c.client_id WHERE order_id = '$oid'");
if ($v->num_rows > 0) {
    $v = $v->fetch_assoc();
    $pid = $v["prod_id"] ?? "";
    $pid = explode(",", $v["prod_id"] ?? "");

    $pidEscaped = array_map(function ($id) use ($conn) {
        return $conn->real_escape_string($id);
    }, $pid);

    $pidList = implode("','", $pidEscaped);

    $prods = $conn->query("SELECT * FROM products WHERE id IN ('$pidList')");

    switch ($v["status"]) {
        case "pending":
            $estado = "Pendiente";
            break;
        case "preparing":
            $estado = "Preparando";
            break;
        case "incoming":
            $estado = "En Camino";
            break;
        case "delivered":
            $estado = "Entregado";
            break;
    }
    ;
}
?>
<!-- ================ Content Order Details ================= -->
<div class="details" style="display: flex;">
    <div class="recentOrders" style="width:100%;display: flex;
    flex-direction: column;">
        <div class="cardHeader">
            <h2># ORDEN ID
                <?php echo $v['order_id']; ?>
            </h2>

            <div class="detalles-pedido" style="display: flex; align-items: center; gap: 2rem;">
                <div class="estado" style="display: flex; align-items: center; gap: 1rem;">
                    <p>Estado: </p>
                    <abbr title="Click para cambiar estado de este pedido" style="text-decoration:none;"
                        order-id="<?php echo $oid; ?>" onclick="changeStatus(this)">
                        <a href="javascript:;">
                            <span class="status <?php echo $v["status"]; ?>">
                                <?php echo $estado; ?>
                            </span>
                        </a>
                    </abbr>
                </div>
            </div>
        </div>
        <h2 style="margin-top:20px;font-weight:700;">
            Datos del Cliente
        </h2>
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
                <tr style="background:#9991" class="hover-tr">
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo $v['client_id'] ?? ''; ?>
                    </td>
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo html_entity_decode(utf8_decode($v['nombre'] ?? ''), ENT_QUOTES, "UTF-8"); ?>
                    </td>
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo $v['documento'] ?? ''; ?>
                    </td>
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo $v['telefono'] ?? ''; ?>
                    </td>
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo $v['email'] ?? ''; ?>
                    </td>
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo html_entity_decode(utf8_decode($v['direccion'] ?? ''), ENT_QUOTES, "UTF-8"); ?>
                    </td>
                    <td style="color:#222 !important; white-space:nowrap;">
                        <?php echo formatDate($v['created_at'] ?? ''); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 style="margin-top:20px;font-weight:700;">
            Productos Solicitados
        </h2>
        <table>
            <thead>
                <tr>
                    <td>Nombre</td>
                    <td>Codigo</td>
                    <td>Precio</td>
                    <td>Foto</td>
                    <td>Fecha</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($prods && $prods->num_rows > 0) {
                    while ($p = $prods->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php echo html_entity_decode(utf8_decode($p['name']), ENT_QUOTES, "UTF-8"); ?>
                            </td>
                            <td>
                                <?php echo $p['cod'] ?>
                            </td>
                            <td>
                                <?php echo '€ ' . $p['price'] ?>
                            </td>
                            <td><img src="../../assets/img/products/<?php echo $p['photo'] ?>" width="120px" height="120px"
                                    style="border-radius: 25px;" /></td>
                            <td>
                                <?php echo formatDate($p['created_at']); ?>
                            </td>
                        </tr>
                    <?php }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    const changeOrderStatus = (orderId) => {
        return new Promise(async (resolve, reject) => {
            try {
                const response = await fetch("../components/changeOrderStatus.php", {
                    method: "POST",
                    body: JSON.stringify({
                        order_id: orderId,
                    })
                });

                if (!response.ok) {
                    throw ("Error en la solicitud.");
                }

                const data = await response.json();

                resolve(data.newstatus);
            } catch (e) {
                reject(e);
            }
        });
    };

    const changeStatus = async (item) => {
        const orderId = item.getAttribute("order-id");
        try {
            let response = await changeOrderStatus(orderId);

            let newstatus = response;
            switch (response) {
                case "pending": newstatus = "Pendiente"; break;
                case "preparing": newstatus = "Preparando"; break;
                case "incoming": newstatus = "En Camino"; break;
                case "delivered": newstatus = "Envíado"; break;
                default: newstatus = "Finalizado"; break;
            };

            item.innerHTML = `<span class="status ${response}">${newstatus}</span>`;

            Swal.fire({
                icon: 'success',
                title: 'Listo!',
                html: 'Cambiaste el estado de este pedido a <span class="status ' + response + '">' + newstatus + '</span> correctamente.',
            });
        } catch (e) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No pudimos cambiar el estado de tu orden debido a un error de servidor.',
            });
        }
    };
</script>