<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\ORM\TableRegistry;

class UsersController extends AppController {
    public $paginate = [
        'contain' => ['Roles']
    ];

    public function index() {
        $users = $this->paginate($this->Users->find()->where(['status' => 1]));
        $this->set(compact('users'));
    }

    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => ['Roles'],
        ]);
        $this->set('user', $user);
    }

    public function add() {
        $listRoles = TableRegistry::get('roles');
        $allRoles = $listRoles->find('all');

        foreach ($allRoles as $roleSingle) {
            $idRoles = $roleSingle->id;
            $roles[$idRoles] = $roleSingle->name;
        }

        $this->set(compact('roles'));

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->getData());

            $user->status = 1;

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user'));

    }

    public function edit($id = null) {
        $listRoles = TableRegistry::get('roles');
        $allRoles = $listRoles->find('all');

        foreach ($allRoles as $roleSingle) {
            $idRoles = $roleSingle->id;
            $roles[$idRoles] = $roleSingle->name;
        }
        $this->set(compact('roles'));

        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null) {

        $user = $this->Users->get($id);
        $user = $this->Users->patchEntity($user, $this->request->getData());
        $user->status = 0;
        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The user could not be saved. Please, try again.'));
        $this->set(compact('user'));
    }
}

