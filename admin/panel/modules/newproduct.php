<div class="container mx-auto py-8">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-semibold mb-4">Crear Producto</h2>
        <form action="../components/uploadProduct.php" method="POST" enctype="multipart/form-data">
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Nombre del producto">
                </div>
                <div class="mb-4">
                    <label for="codigo" class="block text-gray-700 text-sm font-bold mb-2">Código</label>
                    <input type="text" id="codigo" name="codigo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Código del producto" required>
                </div>
                <div class="mb-4">
                    <label for="tipo" class="block text-gray-700 text-sm font-bold mb-2">Tipo</label>
                    <select id="tipo" name="tipo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Selecciona un Tipo de producto</option>
                        <option value="Anillos">Anillos</option>
                        <option value="Pulseras">Pulseras</option>
                        <option value="Collares">Collares</option>
                        <option value="Pendientes">Pendientes</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="tags" class="block text-gray-700 text-sm font-bold mb-2">Tags</label>
                    <input type="text" id="tags" name="tags" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Etiquetas para el producto">
                </div>
                <div class="mb-4">
                    <label for="medidas" class="block text-gray-700 text-sm font-bold mb-2">Medidas</label>
                    <input type="text" id="medidas" name="medidas" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Medidas del producto">
                </div>
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Descripción"></textarea>
                </div>
                <div class="mb-4">
                    <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                    <input type="number" id="stock" name="stock" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required placeholder="Unidades disponibles...">
                </div>
                <div class="mb-4">
                    <label for="precio" class="block text-gray-700 text-sm font-bold mb-2">Precio</label>
                    <input type="text" id="precio" name="precio" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Precio en Euros" required>
                </div>
                <div class="mb-4">
                    <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto</label>
                    <input type="file" id="foto" name="foto" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Crear Producto</button>
            </div>
        </form>
    </div>
</div>