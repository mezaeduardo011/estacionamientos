<?php $breadcrumb=(object)array('actual'=>'Inicio','titulo'=>'Pantalla de Bienvenida del Sistema','ruta'=>'')?>
<?php $this->layout('base',['usuario'=>$usuario,'breadcrumb'=>$breadcrumb])?>

<?php $this->push('title') ?>
Home del Sistema Hornero
<?php $this->end() ?>

<?php $this->push('addCss')?>
<?php $this->end()?>

<!-- Small boxes (Stat box) -->
<div class="row">
<div class="col-lg-12 col-xs-6">
	<div class="row">
    	
	</div>
    <div class="row">

    </div>
</div>
</div>

<?php $this->push('addJs')?>
<!-- Notificciones toastr -->
<script src="/admin/dist/js/core.js"></script>
<script type="text/javascript">
    informar('Bienvenido al Sistema','Bienvenido');
    Core.Menu.main();
</script>
<?php $this->end()?>
