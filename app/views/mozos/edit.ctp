<div class="mozos form">
<?php echo $form->create('Mozo');?>
	<fieldset>
 		<legend><?php __('Edit Mozo');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id', array('empty'=>'No relacionar con usuarios del sistema'));
		echo $form->input('numero');
		echo $form->input('activo',array('after'=>'Solo mozos activos aparecen en la adiciñon. Nunca se debe BORRAR un mozo, lo que hay que hacer es desactivarlo, de ésta manera no se pierden datos estadísticos.'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Borrar', true), array('action'=>'delete', $form->value('Mozo.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Mozo.id'))); ?></li>
		<li><?php echo $html->link(__('Listar Mozos', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('Listar Usuarios', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Nuevo usuario', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('Listar Mesas', true), array('controller'=> 'mesas', 'action'=>'index')); ?> </li>
	</ul>
</div>
