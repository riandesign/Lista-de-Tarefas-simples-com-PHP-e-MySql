<?php
include("conexao.php");

// ID no banco de dados;
$lista_id = 1;

// Recupera tarefas
$query_recupera = "SELECT * FROM tarefas WHERE id = $lista_id";
$tarefas = $mysqli->query($query_recupera)->fetch_object();

// Converte JSON salvo no BD em array utilizável
$lista_de_tarefas = json_decode($tarefas->tarefas);
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  </head>
  <body>

    <h1>Lista de tarefas</h1>

    <form action="atualiza.php" method="post">
      <ul>
        <?php
        $i = 0;
        foreach ($lista_de_tarefas as $tarefa => $status) :
          $i++;
        ?>
          <li>
            <input id="tarefa-<?php echo $i; ?>"
                   type="checkbox"
                   name="tarefas[]"
                   value="<?php echo $tarefa; ?>"
                   <?php if ($status) { echo 'checked'; } ?> >

            <label for="tarefa-<?=$i?>" style="width: 100px; display: inline-block">
              <?php echo $tarefa; ?>
            </label>

            <a href="remove.php?tarefa=<?php echo $tarefa; ?>">Remover</a>
          </li>
        <?php
        endforeach;
        ?>
      </ul>

      <input type="submit" value="Atualizar">
    </form>

    <hr>

    <form action="adiciona.php" method="post">
      <input type="text" placeholder="Descreva a tarefa" name="tarefa" required autofocus>
      <input type="submit" value="Adicionar">
    </form>

    <?php
    // RESULTADO
    if (isset($_GET['resultado'])) :
    ?>
      <div id="resultado" style="margin-top: 20px; background: #f0f0f0; padding: 10px;">
        <?php echo $_GET['resultado']; ?>
      </div>

      <script>
      $(document).ready(function() {
        // Esconde resultado depois de X segundos
        setTimeout(function(){
          $('#resultado').fadeOut();
        }, 2000);
      })
      </script>
    <?php
    endif;
    ?>

  </body>
</html>
