<?php

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
