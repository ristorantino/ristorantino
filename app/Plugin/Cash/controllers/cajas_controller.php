<?php
class CajasController extends CashAppController {

	var $name = 'Cajas';
        
        
        public function index(){
            $this->Caja->recursive = -1;
            $cajas = $this->paginate();
            foreach ( $cajas as &$c ) {
                $c['Caja']['cant_arqueos'] = $this->Caja->Arqueo->find('count', array(
                    'conditions' => array(
                        'Arqueo.caja_id' => $c['Caja']['id']
                    )
                ));
            }
            $this->set(compact('cajas'));
        }
        
        public function add() {
            if (!empty($this->data)) {
                if ($this->Caja->save($this->data)) {
                    $this->Session->setFlash('Se ha guardado la caja correctamente');
                    $this->redirect('index');
                } else {
                    $this->Session->setFlash('Error al guardar');
                }
            }
        }
        
        
        public function edit($id) {
            if (!empty($this->data)) {
                if ($this->Caja->save($this->data)) {
                    $this->Session->setFlash('Se ha guardado la caja correctamente');
                    $this->redirect('index');
                } else {
                    $this->Session->setFlash('Error al guardar');
                }
            } else {
                $this->data = $this->Caja->read(null, $id);
            }
            $this->render('add');
        }
        
        public function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Caja invalida', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Caja->delete($id)) {
			$this->Session->setFlash(__('Caja eliminada', true));
			$this->redirect(array('action'=>'index'));
		}
	}
}
?>