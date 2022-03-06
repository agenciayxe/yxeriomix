<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class LoginController extends AppController {

    public function index () {
        $this->viewBuilder()->setLayout('login');
    	if ($this->Auth->User()) {
            if (!$this->request->is('ajax')) { return $this->redirect($this->Auth->redirectUrl()); }
        }

        $returnEntrar = 'Seu nome de usuário ou senha está incorreto.';
        if ($this->request->is('ajax')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $returnEntrar = true;
            }
            else {  }
            $this->viewBuilder()->setLayout('ajax');
            $this->set(compact('returnEntrar'));
        }
        else if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            else { $this->Flash->error($returnEntrar); }
        }
    }
    public function sair() {
	    return $this->redirect($this->Auth->logout());
	}
}
?>
