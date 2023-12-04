<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href='style.css'>
    <title>Document</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="conteiner">
     <form action="" method="POST">
        
     <div class="form-content">  
        <div >
            <label for="Nombre">Nombre</label>       
            <input type="text" name="Nombre" placeholder="Nombre" class="form-control">
        </div>
        
        <div >
            <label for="Apellido">Apellido</label>
            <input type="text"  class="form-control" name="apellido" placeholder="Apellido">
        </div>

        <div >
            <label for="Mail">Mail</label>
            <input type="text" class="form-control" name="Mail" placeholder="Mail">
        </div>

        <div >
            <label for="Telefono">Telefono</label>
            <input type="text" class="form-control" name="Telefono" placeholder="Telefono">
        </div>

        <div >
            <label for="Contacto">Contacto</label>
            <input type="text" class="form-control" name="Contacto" placeholder="Contacto">
        </div>

        <div>
            <button class="form-control">Enviar</button>
        </div>
        <div>
            <button class="form-control">Borrar</button>
        </div>


     </div>

     </form>


    </div>
    
        <?php include 'footer.php'; ?>

</body>
</html>