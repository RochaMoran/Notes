<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/register.css">
    <title>Registro</title>
</head>
<body class="body-register">
    <form method="POST" action="index.php" class="form-notes form-register">
        <h3 class="text-center text-white p-3">Registrarse</h3>
        <label class="label text-white">Nombre usuario</label>
        <input class="form-control" type="text" placeholder="Nombre de usuario" aria-label="Usuario" name="username">
        <label class="label text-white">Correo Eléctronico</label>
        <input class="form-control" type="text" placeholder="Correo Eléctronico" aria-label="Correo Eléctronico" name="email">
        <label class="label text-white">Contraseña</label>
        <input class="form-control" type="text" placeholder="Contraseña" aria-label="Contraseña" name="password">
        <div class="justify-content-center w-100 d-flex gap-2">
            <a href="./login.php" class="btn btn-light mt-4">Iniciar Sesion</a>
            <input type="submit" text="Enviar" class="btn btn-primary mt-4"/>
        </div>
    </form>

    <?php
        require('./services/database.php');

        if (!empty($_POST)) {
            $conection = new Conection();
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $conection -> singUp($email, $password, $username);
        }
    ?>
</body>
</html>