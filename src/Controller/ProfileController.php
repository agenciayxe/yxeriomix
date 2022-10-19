<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\Datasource\FactoryLocator;

class ProfileController extends AppController {

    public function index() {
        $userCurrent = $this->usuarioAtual;
        $id = $userCurrent['id'];
        $listUsers = FactoryLocator::get('Table')->get('Users');

        $user = $listUsers->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $listUsers->patchEntity($user, $this->request->getData());

            if ($listUsers->save($user)) {
                $this->Flash->success(__('Dados atualizados com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Dados não atualizados'));
        }
        $this->set(compact('user'));
    }

    public function settings() {
        $userCurrent = $this->usuarioAtual;
        $id = $userCurrent['id'];
        $listUsers = FactoryLocator::get('Table')->get('Users');

        $user = $listUsers->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $getData = $this->request->getData();
            $user = $listUsers->patchEntity($user, $getData);
            $menu_show = (isset($getData['menu_show'])) ? 1: 0;
            $menu_minimized = (isset($getData['menu_minimized'])) ? 1: 0;

            $user->menu_show = $menu_show;
            $user->menu_minimized = $menu_minimized;
            $saveUser = $listUsers->save($user);
            if ($saveUser) {
                $this->usuarioAtual = $user;
                $this->Flash->success(__('Preferências salvas, saia e entre da sua conta para que as configurações sejam aplicadas.'));
            }
            $this->Flash->error(__('Configurações não foram salvas.'));
        }
        $this->set(compact('user'));
    }
}

