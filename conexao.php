<?php
// Dados para conectar ao banco
$mysqli = new mysqli("localhost", "root", "", "listadetarefas");
// Verifica conexão
if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit();
}
?>
