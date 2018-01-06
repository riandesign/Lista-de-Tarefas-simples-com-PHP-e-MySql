<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_POST['tarefa'] == '') {
  header('location: index.php');
}

include("conexao.php");
include("funcoes.php");

// ID no banco de dados;
$lista_id = 1;
$resultado = null;

// Recupera tarefas
$query_recupera = "SELECT * FROM tarefas WHERE id = $lista_id";
$tarefas = $mysqli->query($query_recupera)->fetch_object();

// Converte JSON salvo no BD em array utilizável
$lista_de_tarefas = json_decode($tarefas->tarefas);

// Tarefa a ser adicionada
$nova_tarefa = mysql_real_escape_string(trim($_POST['tarefa']));


// Se a lista estiver vazia, cria lista com a nova e única tarefa
if (count($lista_de_tarefas) == 0) {
  $tarefas_atualizadas_json = json_encode(array($nova_tarefa => 0), JSON_UNESCAPED_UNICODE);
}
// Se a lista NÃO estiver vazia, adiciona a nova tarefa
else {
  $lista_de_tarefas->$nova_tarefa = 0;
  $tarefas_atualizadas_json = json_encode($lista_de_tarefas, JSON_UNESCAPED_UNICODE);
}

$resultado = atualiza_bd($mysqli, $lista_id, $tarefas_atualizadas_json);
header('location: index.php?resultado=' . $resultado);
?>
