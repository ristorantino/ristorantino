<div class="comanderas index">
<h2><?php __('Comanderas');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('path');?></th>
	<th><?php echo $paginator->sort('imprime_ticket');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($comanderas as $comandera):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $comandera['Comandera']['id']; ?>
		</td>
		<td>
			<?php echo $comandera['Comandera']['name']; ?>
		</td>
		<td>
			<?php echo $comandera['Comandera']['description']; ?>
		</td>
		<td>
			<?php echo $comandera['Comandera']['path']; ?>
		</td>
		<td>
			<?php echo $comandera['Comandera']['imprime_ticket']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $comandera['Comandera']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $comandera['Comandera']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $comandera['Comandera']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $comandera['Comandera']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Comandera', true), array('action'=>'add')); ?></li>
	</ul>
</div>
