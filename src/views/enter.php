<!-- inicia php -->
<?php
include_once 'src/blocks/header.php';

?>

<h1>En sesion</h1>

<!-- imprime los datos en sesion -->
<?php
echo $_SESSION['user'];
echo $_SESSION['email'];
echo $_SESSION['id'];
echo $_SESSION['role'];
?>

<?php
include_once 'src/blocks/footer.php';
?>