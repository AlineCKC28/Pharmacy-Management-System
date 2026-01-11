<?php
session_start();
if($_SESSION['us_tipo']==2){
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnico</title>
</head>
<body>
    <h1>Olá Técnico</h1>
    <a href="../controlador/logout.php">Encerrar sessão</a>
</body>
</html>
<?php
}
else(
    header('Location: ../index.php')
)
?> 