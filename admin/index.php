<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sembra | Login Admin Dashboard</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php 
            session_start();
            if(isset($_SESSION['id'])){
            	header('location:./panel/');
            } 
            ?>
    </head>
    <body>
        <!-- This is an example component -->
        <div class="h-screen font-sans login bg-cover">
            <div class="container mx-auto h-full flex flex-1 justify-center items-center">
                <div class="w-full max-w-lg">
                    <div class="leading-loose">
                        <form class="max-w-sm m-4 p-10 bg-white bg-opacity-30 rounded shadow-xl" method="post" action="./components/login.php">
                            <p class="text-slate-600 font-medium text-center text-lg font-bold">Admin Dashboard</p>
                            <?php  
                                if(isset($_SESSION['error'])){ 
                                	?>
                            <div class="bg-indigo-900 p-2 text-center" id="alert">
                                <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                                    <span class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error!</span>
                                    <span class="font-semibold mr-2 text-left flex-auto"><?php echo $_SESSION['error']??''; ?></span>
                                </div>
                            </div>
                            <script>
                                const alert = document.getElementById('alert');
                                setTimeout(()=>{
                                	alert.style.display='none';
                                },3000);
                            </script>
                            <?php	
                                unset($_SESSION['error']);
                                }
                                ?>
                            <div class="mt-2">
                                <label class="block text-sm text-slate-600" for="username">Nombre de Usuario</label>
                                <input class="w-full px-5 py-1 text-gray-700 bg-gray-300 rounded focus:outline-none focus:bg-white" type="text" id="username"  placeholder="Ingresa tu nombre de Usuario" required aria-label="text" name="username" required>
                            </div>
                            <div class="mt-2">
                                <label class="block  text-sm text-slate-600">Contraseña</label>
                                <input class="w-full px-5 py-1 text-gray-700 bg-gray-300 rounded focus:outline-none focus:bg-white"
                                    type="password" id="password" name="password" required placeholder="Ingresa tu contraseña" arial-label="password" required>
                            </div>
                            <div class="mt-4 items-center flex justify-between">
                                <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 hover:bg-gray-800 rounded"
                                    type="submit">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .login{
            /*
            background: url('https://tailwindadmin.netlify.app/dist/images/login-new.jpeg');
            */
            background: url('../assets/img/bosuqe.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            }
        </style>
    </body>
</html>
