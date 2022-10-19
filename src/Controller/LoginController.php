<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class LoginController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        $this->loadComponent('Authentication.Authentication');
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index']);
    }
    public function index () {

        $this->viewBuilder()->setLayout('login');
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/dashboard';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Usuário ou senha incorreto, tente novamente.');
        }
    }
    public function sair() {
	    $this->Authentication->logout();
        return $this->redirect(['controller' => 'login', 'action' => 'index']);
	}
}
?>
