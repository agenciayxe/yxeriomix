<?php
declare(strict_types=1);
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Datasource\FactoryLocator;

class AppController extends Controller
{
    public $usuarioAtual = false;

    public function initialize(): void
    {
        parent::initialize();

    	$this->loadComponent('Authentication.Authentication');

        $this->loadComponent('Flash');

        $usuarioAtual = $this->Authentication->getIdentity();
        $this->usuarioAtual = $usuarioAtual;
        if ($usuarioAtual && $usuarioAtual->status == 0) {
            $this->Authentication->logout();
            $this->Flash->error('Você não pode acessar o sistema.');
            $this->redirect(['controller' => 'login', 'action' => 'index']);
        }
        $this->set(compact('usuarioAtual'));
    }
}

