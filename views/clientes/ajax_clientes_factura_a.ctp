<?php $paginator->options(array('update' => 'listado-clientes-ajax'))?>

<div id="listado-clientes-ajax">
	<table>
		<tr class="listado"> 
			<th><?php echo $paginator->sort('Cuit', 'cuit'); ?></th> 
			<th><?php echo $paginator->sort('Denominación', 'denominacion'); ?></th>
			<th><?php echo $paginator->sort('Domicilio', 'domicilio_fiscal'); ?></th>  
			<th>+</th>  
		</tr> 
		   <?php foreach($clientes as $c): ?> 
		<tr  class="listado"> 
			<td><?php echo $c['Cliente']['cuit']; ?> </td> 
			<td><?php echo $c['Cliente']['denominacion']; ?> </td>
			<td><?php echo $c['Cliente']['domicilio_fiscal']; ?> </td>  
			<td><a href="#AgregarCliente" onclick="agregarClienteACurrentMesa(<?php echo $c['Cliente']['id'];?>)">ADD</a></td> 
		</tr> 
		<?php endforeach; ?> 
	</table> 
</div>

<div id="listado-clientes-paginador" class="menu-horizontal">
<ul>
	<!-- Muestra los enlaces para Anterior -->
	<li><?php echo $paginator->prev('« - ', array('class' => 'boton'), null, array('class' => 'disabled boton'));?></li>
	
	<!-- Muestra los números de página -->
	<?php echo $paginator->numbers(array('tag'=>'li','class'=>'boton')); ?>
	
	<!-- Muestra los enlaces para Siguiente -->	
	<li><?php echo $paginator->next(' + »', array('class' => 'boton'), null, array('class' => 'disabled boton'));?></li>
	
	<!-- Muestra X de Y, donde X es la página actual e Y el total del páginas -->
	<?php // echo $paginator->counter(); ?>
	</ul>
</div>