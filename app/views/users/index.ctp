        <?php    
        $menubread=array();
        echo $this->element('menuadmin', array('menubread'=>$menubread));
        ?>

<div class="users index">
<h2><?php __('Usuarios');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Pagina %page% de %pages%, mostrando %current% elementos de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Usuario','username');?></th>
	<th><?php echo $paginator->sort('nombre');?></th>
	<th><?php echo $paginator->sort('apellido');?></th>
        <th><?php echo $paginator->sort('Rol','role');?></th>
	<th><?php echo $paginator->sort('telefono');?></th>
	<th class="actions"><?php __('Acciones');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			<?php echo $user['User']['nombre']; ?>
		</td>
		<td>
			<?php echo $user['User']['apellido']; ?>
		</td>
                <td>
			<?php echo $user['User']['role']; ?>
		</td>
		<td>
			<?php echo $user['User']['telefono']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $user['User']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $user['User']['id'])); ?>
			<?php echo $html->link(__('Borrar', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('¿Está seguro que desea borrar el usuario: %s?', true), $user['User']['username'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próximo', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Listar mozos', true), array('controller'=> 'mozos', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Crear usuario', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('Crear mozo', true), array('controller'=> 'mozos', 'action'=>'add')); ?> </li>
	</ul>
</div>
