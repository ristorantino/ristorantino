<?php
class MesasController extends AppController {

	var $name = 'Mesas';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Mesa->recursive = 0;
		$this->set('mesas', $this->paginate());
	}

	function view($id = null) {
		$this->layout='ajax';
		if (!$id) {
			$this->Session->setFlash(__('Invalid Mesa.', true));
			$this->redirect(array('action'=>'index'));
		}
		
		
		$this->Mesa->Comanda->order = 'Comanda.created';
		$this->Mesa->Comanda->recursive = 1;
		$items = $this->Mesa->Comanda->find('all',array('conditions'=>array('Comanda.mesa_id'=>$id),
														'fields'=> array('Comanda.mesa_id','Comanda.producto_id','sum(Comanda.cant)', 'Producto.name', 'Mesa.numero'),
														'group'=> array('mesa_id','producto_id', 'Producto.name','Mesa.numero')));
		$mesa = $this->Mesa->read(null, $id);	
		$this->set(compact('mesa', 'items'));	
		$this->set('mesa_json', json_encode($mesa));
		$this->set('mozo_json', json_encode($this->Mesa->Mozo->read(null, $mesa['Mozo']['id'])));
	}

	function abrirMesa() {
		if (!empty($this->data)) {
			$this->Mesa->create();
			if ($this->Mesa->save($this->data)) {
				$this->Session->setFlash(__('Se abrió la mesa n° '.$this->data['Mesa']['numero'], true));
				//debug($this->data);
				$this->Mesa->Mozo->id = $this->data['Mesa']['mozo_id'];
				$this->data = $this->Mesa->Mozo->read();
				
				$this->redirect(array(	'controller'=>'Adicion', 
										'action' => 'adicionar/mozo_id:'.$this->data['Mozo']['id']));
			} else {
				$this->Session->setFlash(__('La mesa no pudo ser abierta. Intente nuevamente.', true));
			}
		}
		
	}

	function add() {
		if (!empty($this->data)) {
			$this->Mesa->create();
			if ($this->Mesa->save($this->data)) {
				$this->Session->setFlash(__('The Mesa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Mesa could not be saved. Please, try again.', true));
			}
		}
		$mozos = $this->Mesa->Mozo->find('list');
		$descuentos = $this->Mesa->Descuento->find('list');
		$this->set(compact('mozos', 'descuentos'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Mesa', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Mesa->save($this->data)) {
				$this->Session->setFlash(__('The Mesa has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Mesa could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Mesa->read(null, $id);
		}
		$mozos = $this->Mesa->Mozo->find('list');
		$descuentos = $this->Mesa->Descuento->find('list');
		$this->set(compact('mozos','descuentos'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Mesa', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Mesa->del($id)) {
			$this->Session->setFlash(__('Mesa deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>