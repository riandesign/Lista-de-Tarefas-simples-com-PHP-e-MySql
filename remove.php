<?php
if (!$_GET['tarefa'] || $_GET['tarefa'] == '') {
  header('location: index.php');
}

include("conexao.php");

// ID no banco de dados;
$lista_id = 1;
$resultado = null;

// Tarefa a ser removida
$tarefa_removida = $_GET['tarefa'];

// Recupera tarefas
$query_recupera = "SELECT * FROM tarefas WHERE id = $lista_id";
$tarefas = $mysqli->query($query_recupera)->fetch_object();

// Converte JSON salvo no BD em array utilizável
$lista_de_tarefas = json_decode($tarefas->tarefas);
$lista_de_tarefas = $lista_de_tarefas;

// Inicializa lista de tarefas atualizada
$tarefas_atualizadas = array();

// Procura pela tarefa e a remove da lista
foreach ($lista_de_tarefas as $tarefa => $status) {
  if ($tarefa != $tarefa_removida) {
    $tarefas_atualizadas[$tarefa] = $status;
  }
}


$tarefas_atualizadas_json = json_encode($tarefas_atualizadas, JSON_UNESCAPED_UNICODE);
$resultado = atualiza_bd($mysqli, $lista_id, $tarefas_atualizadas_json);

header('location: index.php?resultado=' . $resultado);

/*
 * Atualiza lista de tarefas no banco de dados
 * Retorna string (resultado)
 */
function atualiza_bd($mysqli = null, $lista_id = null, $tarefas_atualizadas_json = null) {
  if (!isset($mysqli) || !isset($lista_id) || !isset($tarefas_atualizadas_json))
    return ;

  $query = "UPDATE tarefas SET tarefas = '$tarefas_atualizadas_json' WHERE id = $lista_id";

  if ($mysqli->query($query)) {
    return 'Lista de tarefas atualizada com sucesso.';
  } else {
    return 'Erro: ' . $mysqli->error;
  }
}
?>
