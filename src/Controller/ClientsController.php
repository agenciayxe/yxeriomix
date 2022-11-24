<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;

class ClientsController extends AppController {

    public function index() {

        $pesquisa = $this->request->getQuery('s');

        $clients = $this->paginate($this->Clients->find('all', [
            'conditions' => [
                'OR' => [
                    'Clients.email LIKE' => '%' . $pesquisa . '%',
                    'Clients.name LIKE' => '%' . $pesquisa . '%',
                    'Clients.cpf_cnpj LIKE' => '%' . $pesquisa . '%',
                    'Clients.phone LIKE' => '%' . $pesquisa . '%',
                ]
            ]
        ]));

        $this->set(compact('pesquisa'));
        $this->set(compact('clients'));
    }

    public function view($id = null) {
        $client = $this->Clients->get($id, [
            'contain' => ['Statuses', 'Sales'],
        ]);
        $listSales = FactoryLocator::get('Table')->get('Sales');
        $clientsCustomers = FactoryLocator::get('Table')->get('Customers');
        $sales = $listSales->find('all')->where(['Sales.client_id' => $id])->order(['location_id' => 'ASC'])->contain(['Locations']);

        $listCustomers = $clientsCustomers->find('all')->where(['client_id' => $id]);
        $this->set(compact('listCustomers'));

        $this->set('client', $client);
        $this->set('sales', $sales);
    }

    public function add() {

        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        $listStatus = FactoryLocator::get('Table')->get('Statuses');

        $allStatuses = $listStatus->find('all');

        foreach ($allStatuses as $statusSingle) {
            $idStatus = $statusSingle->id;
            $statuses[$idStatus] = $statusSingle->title;
        }

        $this->set(compact('statuses'));

        $client = $this->Clients->newEmptyEntity();

        $customer = $listCustomers->newEmptyEntity();
        if ($this->request->is('post')) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            $client->status_id = 1;
            $clientSave = $this->Clients->save($client);
            if ($clientSave) {

                $customer = $listCustomers->patchEntity($customer, $this->request->getData());
                $customer->client_id = $clientSave->id;
                $customer->status = 1;
                $listCustomers->save($customer);

                $this->Flash->success(__('O cliente foi cadastrado com sucesso'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O cadastro não foi efetuado com sucesso'));
        }
        $this->set(compact('client'));
    }

    public function edit($id = null) {

        $listStatus = FactoryLocator::get('Table')->get('Statuses');

        $allStatuses = $listStatus->find('all');

        foreach ($allStatuses as $statusSingle) {
            $idStatus = $statusSingle->id;
            $statuses[$idStatus] = $statusSingle->title;
        }

        $this->set(compact('statuses'));

        $client = $this->Clients->get($id, [
            'contain' => [],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $client = $this->Clients->patchEntity($client, $this->request->getData());

            if ($this->Clients->save($client)) {
                $this->Flash->success(__('Os dados foram atualizados com sucesso'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Os dados não foram atualizados, tente novamente'));
        }
        $this->set(compact('client'));
    }

    public function delete($id = null) {

        $this->request->allowMethod(['post', 'delete']);

        $client = $this->Clients->get($id);

        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('Os dados foram deletados com sucesso'));
        } else {
            $this->Flash->error(__('Os dados não foram deletados, tente novamente'));
        }
        return $this->redirect(['action' => 'index']);

    }

}

