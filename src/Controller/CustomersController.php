<?php
declare(strict_types=1);
namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\FactoryLocator;

class CustomersController extends AppController {
    public $paginate = [
        // 'contain' => ['Clients']
    ];

    public function index() {
        $customers = $this->paginate($this->Customers->find()->where(['status' => 1]));
        $this->set(compact('customers'));
    }

    public function view($id = null) {
        $clientsTable = FactoryLocator::get('Table')->get('Clients');
        $customer = $this->Customers->get($id, [

        ]);
        $clientId = $customer->client_id;
        if ($clientId) {
            $listClient = $clientsTable->find('all')->where(['id' => $clientId]);
            $clientCurrent = $listClient->firstOrFail();

            $this->set(compact('clientCurrent'));
        }
        $this->set('customer', $customer);
    }

    public function add() {
        $listRoles = FactoryLocator::get('Table')->get('Roles');
        $allRoles = $listRoles->find('all');

        foreach ($allRoles as $roleSingle) {
            $idRoles = $roleSingle->id;
            $roles[$idRoles] = $roleSingle->name;
        }
        unset($roles[1]);

        $this->set(compact('roles'));

        $customer = $this->Customers->newEmptyEntity();

        if ($this->request->is('post')) {

            $customer = $this->Customers->patchEntity($customer, $this->request->getData());

            $customer->status = 1;
            $customer->date_created = date("Y-m-d H:i:s", strtotime("NOW"));;

            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }

        $this->set(compact('customer'));

    }

    public function edit($id = null) {
        $listRoles = FactoryLocator::get('Table')->get('Roles');
        $allRoles = $listRoles->find('all');

        foreach ($allRoles as $roleSingle) {
            $idRoles = $roleSingle->id;
            $roles[$idRoles] = $roleSingle->name;
        }
        unset($roles[1]);
        $this->set(compact('roles'));

        $customer = $this->Customers->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());

            // $passwordHash = new DefaultPasswordHasher();
            // $customer->password = $passwordHash->hash($customer->password);

            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
    }

    public function delete($id = null) {

        $customer = $this->Customers->get($id);
        $customer = $this->Customers->patchEntity($customer, $this->request->getData());
        $customer->status = 0;
        if ($this->Customers->save($customer)) {
            $this->Flash->success(__('The customer has been saved.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        $this->set(compact('customer'));
    }
}

