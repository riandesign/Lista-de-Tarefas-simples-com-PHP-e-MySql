<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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

// Inicializa lista de tarefas atualizada
$tarefas_atualizadas = array();

// Se houver alguma tarefa marcada, verifica qual é true
if (isset($_POST['tarefas'])) {
  $tarefas_post = $_POST['tarefas'];

  foreach ($lista_de_tarefas as $tarefa => $status) {
    if (in_array($tarefa, $tarefas_post)) {
      $tarefas_atualizadas[$tarefa] = 1;
    } else {
      $tarefas_atualizadas[$tarefa] = 0;
    }
  }
}
// Se nenhum tarefa for marcada, todas serão false
else {
  foreach ($lista_de_tarefas as $tarefa => $status) {
    $tarefas_atualizadas[$tarefa] = 0;
  }
}

$tarefas_atualizadas_json = json_encode($tarefas_atualizadas, JSON_UNESCAPED_UNICODE);
$resultado = atualiza_bd($mysqli, $lista_id, $tarefas_atualizadas_json);
header('location: index.php?resultado=' . $resultado);
?>
