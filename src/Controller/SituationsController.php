<?php
declare(strict_types=1);

namespace App\Controller;

class SituationsController extends AppController {
    public function index()
    {
        $situations = $this->paginate($this->Situations);

        $this->set(compact('situations'));
    }
    public function ver($id = null) {
        $situation = $this->Situations->get($id, [
            'contain' => [],
        ]);

        $this->set('situation', $situation);
    } 
    public function adicionar() {
        $situation = $this->Situations->newEmptyEntity();
        if ($this->request->is('post')) {
            $situation = $this->Situations->patchEntity($situation, $this->request->getData());
            if ($this->Situations->save($situation)) {
                $this->Flash->success(__('The situation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The situation could not be saved. Please, try again.'));
        }
        $this->set(compact('situation'));
    }
    public function editar($id = null) {
        $situation = $this->Situations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $situation = $this->Situations->patchEntity($situation, $this->request->getData());
            if ($this->Situations->save($situation)) {
                $this->Flash->success(__('The situation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The situation could not be saved. Please, try again.'));
        }
        $this->set(compact('situation'));
    }
    
    public function deletar($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $situation = $this->Situations->get($id);
        if ($this->Situations->delete($situation)) {
            $this->Flash->success(__('The situation has been deleted.'));
        } else {
            $this->Flash->error(__('The situation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
