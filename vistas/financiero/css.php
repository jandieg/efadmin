
<style>
.lista-botones {
  
    display: flex;
    flex-wrap: nowrap;
    
    justify-content: center;

  align-items: stretch;
}
.flex-container2 {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
/*
.Enero {
    grid-area: enero;
}

.Febrero {
    grid-area: febrero;
}

.Marzo {
    grid-area: marzo;
}

.Abril{
    grid-area: abril;
}

.Mayo{
    grid-area: mayo;
}

.Junio{
    grid-area: junio;
}

.Julio{
    grid-area: julio;
}

.Agosto{
    grid-area: agosto;
}

.Septiembre{
    grid-area: septiembre;
}

.Octubre{
    grid-area: octubre;
}

.Noviembre{
    grid-area: noviembre;
}

.Diciembre{
    grid-area: diciembre;
}*/

.container-grids {
  display: grid;
  justify-items: center;
  grid-template-columns: 200px 100px 200px;
  grid-template-rows: auto;
  grid-template-areas: 
    "enero enero enero"    
    "febrero febrero febrero"
    "marzo marzo marzo"
    "abril abril abril"
    "mayo mayo mayo"
    "junio junio junio"
    "julio julio julio"
    "agosto agosto agosto"
    "septiembre septiembre septiembre"
    "octubre octubre octubre"
    "noviembre noviembre noviembre"
    "diciembre diciembre diciembre"
    ;
}
</style>