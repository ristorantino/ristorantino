    <?php    
    echo $this->element('menuadmin');
    ?>



<div class="clientes index">
<h2><?php __('Clientes');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% elementos de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
        <th><?php echo $paginator->sort('nombre');?></th>
        <th><?php echo $paginator->sort('Usuario','User.username');?></th>
	<th><?php echo $paginator->sort('Descuento','Descuento.name');?></th>
        <th style="text-align: center;"><?php echo $paginator->sort('IVA','IvaResponsabilidad');?></th>
	<th><?php echo $paginator->sort('Factura','tipofactura');?></th>
	<th><?php echo $paginator->sort('Ticket','imprime_ticket');?></th>
	<th><?php echo $paginator->sort('CUIT/CUIL/DNI', 'nrodocumento');?></th>
	<th><?php echo $paginator->sort('Creado','created');?></th>
	<th class="actions"><?php __('Acciones');?></th>
</tr>
<?php

if ($paginator->params['paging']['Cliente']['count']!=0) {
$i = 0;
foreach ($clientes as $cliente):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
                <td>
			<?php echo $cliente['Cliente']['nombre']; ?>
		</td>
		<td title="<?php echo $cliente['User']['nombre'].", ".$cliente['User']['apellido']; ?>">
			<?php echo $cliente['User']['username']; ?>
		</td>
		<td title="<?php echo $cliente['Descuento']['description']." (%".$cliente['Descuento']['porcentaje'].")"; ?>">
			<?php echo $cliente['Descuento']['name']; ?>
		</td>
                <td>
			<?php echo ($cliente['IvaResponsabilidad']['name']); ?>
		</td>
		<td style="text-align: center;">
			<?php echo ($cliente['Cliente']['tipofactura'])?'"'.$cliente['Cliente']['tipofactura'].'"':'Remito'; ?>
		</td>

		<td style="text-align: center;">
			<?php echo ($cliente['Cliente']['imprime_ticket'])?'Si':'No'; ?>
		</td>
		
		<td>
			<?php 
                         echo (!empty($cliente['TipoDocumento']['name']))?$cliente['Cliente']['nrodocumento']." (".$cliente['TipoDocumento']['name'].")":''; 
                         ?>
		</td>
		<td>
			<?php echo date('d/m/Y H:i',strtotime($cliente['Cliente']['created'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $cliente['Cliente']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $cliente['Cliente']['id'])); ?>
			<?php echo $html->link(__('Borrar', true), array('action'=>'delete', $cliente['Cliente']['id']), null, sprintf(__('¿Está seguro que desea borrar el cliente: %s?', true), $cliente['Cliente']['nombre'])); ?>
		</td>
	</tr>
<?php endforeach; 
}else{
    echo('<td>No se encontraron clientes</td>');
}
?>

        <tr>
	<?php echo $form->create("Cliente",array("action"=>"index")); echo $form->input("id") ?>
	<th><?php echo $form->input('nombre',array('style'=>'width:170px;','placeholder'=>'Nombre del cliente', 'label'=>false));?></th>
	<th></th>
	<th></th>
	<th></th>
        <th></th>
        <th></th>
	<th><?php echo $form->input('nrodocumento',array('style'=>'width:120px;','placeholder'=>'CUIT / CUIL / DNI','label'=>false));?></th>
        <th></th>
	<th class="actions"><?php echo $form->end("Buscar")?></th>
        </tr>
   
        
</table>

</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próximo', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Crear Cliente', true), array('action'=>'add')); ?></li>
	</ul>
</div>
