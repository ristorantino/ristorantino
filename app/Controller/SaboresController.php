<?php
class SaboresController extends AppController {

	var $name = 'Sabores';
	var $helpers = array('Html', 'Form');
        
        function beforeFilter() {
            parent::beforeFilter();
        }
        
	function index() {
		if(!empty($this->request->data)){
			$condiciones = array();
			foreach($this->request->data as $modelo=>$campos){
				foreach($campos as $key=>$val){
					if(!is_array($val))
						$condiciones[] = array($modelo.".".$key." LIKE"=>'%'.$val.'%');
				}
			}
			$this->Producto->recursive = 0;
			foreach($this->modelNames as $modelo){
				$this->paginate[$modelo] = array(
					'conditions' => $condiciones
				);
			}
		}
		$this->Sabor->recursive = 0;
		
		$sabores = $this->paginate('Sabor');
		
		$this->set('sabores',$sabores);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Sabor.'));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('sabor', $this->Sabor->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Sabor->create();
			if ($this->Sabor->save($this->request->data)) {
				$this->Session->setFlash(__('The Sabor has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Sabor could not be saved. Please, try again.'));
			}
		}
		$categorias = $this->Sabor->Categoria->generatetreelist(null, null, null, '___');
		$this->set(compact('categorias'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid Sabor'));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Sabor->save($this->request->data)) {
				$this->Session->setFlash(__('The Sabor has been saved'));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Sabor could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Sabor->read(null, $id);
		}
		$categorias = $this->Sabor->Categoria->generatetreelist(null, null, null, '___');
		$this->set(compact('categorias'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Sabor'));
		}
		if ($this->Sabor->del($id)) {
			$this->Session->setFlash(__('Sabor deleted'));
		}
                $this->redirect(array('action'=>'index'));
	}

}
?>