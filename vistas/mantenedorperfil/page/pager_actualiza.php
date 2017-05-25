 <div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{titulo}</h3>
        <div class="box-tools pull-right">
            <input type="text" style="visibility:hidden;" class="" id="c_id" placeholder="" required="" value="{id}">
        </div>
      </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal">
        <div class="box-body">
    <div class="form-group">
      <label for="" class="col-sm-3 control-label">Descripción</label>
      <div class="col-sm-9">
          <input type="text" class="form-control" id="c_descrpcion" placeholder="Descripción" required="required" value="{descripcion}">
      </div>
    </div>
    <div class="form-group">
       <label for="" class="col-sm-3 control-label">Estado</label>
       <div class="col-sm-9">
        <select id="c_estado" class="form-control">
            <option value="A" {a}>Activo</option>
            <option value="I" {i}>Inactivo</option>
        </select>
       </div>
   </div>

  </div>
  <!-- /.box-body -->
  {operaciones}
  <!-- /.box-footer -->
</form>
</div>
<div id="ben_respuesta_operacion"></div>
        
       