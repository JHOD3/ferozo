<!-- Modal -->
<div class="modal fade" id="modal_permisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Permisos</h4>
      </div>

      <form id="form_permisos" method="POST" action="#">
        <div class="modal-body">
          <table class="table">
            <?php
            echo '<tr>';
        echo '<th></th>';
        foreach ($tipos as $key => $tipo)
        {
          echo '<th>'.$tipo['cob_usr_tipo_desc'].'</th>';
        }
      echo '</tr>';
      echo '<tr>';
        echo '<td>Ver</td>';
        foreach ($tipos as $key => $tipo)
        {
          echo '<td><input type="checkbox"></td>';
        }
      echo '</tr>';
      echo '<tr>';
        echo '<td>Comentar</td>';
        foreach ($tipos as $key => $tipo)
        {
          echo '<td><input type="checkbox"></td>';
        }
      echo '</tr>';
      echo '<tr>';
        echo '<td>Editar</td>';
        foreach ($tipos as $key => $tipo)
        {
          echo '<td><input type="checkbox"></td>';
        }
      echo '</tr>';
            ?>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?=mostrar_palabra(29, $palabras)?></button>
          <button type="submit" class="btn btn-danger" id="btn_referenciar"><?=mostrar_palabra(17, $palabras)?></button>
        </div>
      </form>

    </div>
  </div>
</div>


<script type="text/javascript">
function abrir_permisos()
{
  $('#modal_permisos').modal('show');
}
</script>