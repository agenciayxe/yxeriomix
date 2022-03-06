<?php
declare(strict_types=1);
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{
    public $usuarioAtual = false;

    public function initialize(): void
    {
        parent::initialize();
    	if ($this->request->getParam('controller') != 'Api') {
            $this->loadComponent('Auth', [
                'loginAction' => [
                    'controller' => 'login',
                    'action' => 'index'
                ],
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'username',
                            'password' => 'password'
                        ],
                        'userModel' => 'users'
                    ]
                ],
                'loginRedirect' => [
                    'controller' => 'dashboard',
                    'action' => 'index'
                ],
                'logoutRedirect' => [
                    'controller' => 'login',
                    'action' => 'index'
                ],
                'authError' => 'Login não efetuado, tente entrar em sua conta.',
            ]);

            $this->Auth->allow(['sair']);
            $this->loadComponent('Flash');

            $usuarioAtual = $this->Auth->User();;
            $this->usuarioAtual = $usuarioAtual;
            $this->set(compact('usuarioAtual'));

            $this->viewBuilder()->setLayout('default');

            $this->loadComponent('RequestHandler');
        }
    }
}
