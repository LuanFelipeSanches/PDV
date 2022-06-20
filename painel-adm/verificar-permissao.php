<?php
//Verificar permissão do usuário
if (@$_SESSION['nivel_usuario']  != 'Administrador') {
    echo "<script language='javascript'>window.location='../index.php'</script>";
}