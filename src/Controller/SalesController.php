<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;

class SalesController extends AppController
{
    public function index() {
        $listTech = TableRegistry::get('users');
        $technicians = $listTech->find('all')->where(['role_id' => 2, 'status' => 1]);

        $this->set(compact('technicians'));
    }
    public function pesquisa()
    {
        $pesquisa = ($this->request->getQuery('s')) ? $this->request->getQuery('s'): '';
        $this->paginate = [
            'contain' => ['Clients']
        ];
        $sales = $this->paginate($this->Sales->find('all'));

        $this->set(compact('sales'));
        $this->set(compact('pesquisa'));
    }
    public function view($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Clients']
        ]);

        $listUsers = TableRegistry::get('users');
        $technicianData = ($sale->technician_id) ? $listUsers->get($sale->technician_id): null;
        $sellerData = ($sale->seller_id) ? $listUsers->get($sale->seller_id): null;

        $this->set(compact('technicianData'));
        $this->set(compact('sellerData'));
        $this->set('sale', $sale);
    }
    public function add() {

    }
    public function addcomplete() {

        $listClients = TableRegistry::get('clients');
        $listStatus = TableRegistry::get('statuses');
        $listCustomers = TableRegistry::get('customers');

        $allStatuses = $listStatus->find('all');
        foreach ($allStatuses as $statusSingle) {
            $idStatus = $statusSingle->id;
            $statuses[$idStatus] = $statusSingle->title;
        }
        $this->set(compact('statuses'));

        $client = $listClients->newEmptyEntity();
        $sale = $this->Sales->newEmptyEntity();
        $customer = $listCustomers->newEmptyEntity();
        if ($this->request->is('post')) {
            $client = $listClients->patchEntity($client, $this->request->getData());
            $client->status_id = 1;
            $clientSave = $listClients->save($client);
            if ($clientSave) {

                if ($this->request->is('post')) {
                    $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                    $sale->client_id = $clientSave->id;
                    $sale->coeficiente = $sale->devolucao / $sale->vendas;
                    $sale->economia = 0.8 * $sale->devolucao;
                    if ($this->Sales->save($sale)) {
                        $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                        $this->Sales->save($sale);

                        $customer = $listCustomers->patchEntity($customer, $this->request->getData());
                        $customer->client_id = $clientSave->id;
                        $customer->status = 1;
                        $passwordHash = new DefaultPasswordHasher();
                        $customer->password = $passwordHash->hash($customer->password);
                        $listCustomers->save($customer);

                        $this->Flash->success(__('Servi??o e cliente salvo com sucesso.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('O servi??o n??o foi salvo, tente novamente.'));
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O cliente n??o foi salvo, tente novamente.'));
        }
        $this->set(compact('sale'));
        $this->set(compact('client'));
    }

    public function addsale() {

        $listClients = TableRegistry::get('clients');
        $listTechnicians = TableRegistry::get('users');

        $listStatus = TableRegistry::get('statuses');
        $allStatuses = $listStatus->find('all');
        foreach ($allStatuses as $statusSingle) {
            $idStatus = $statusSingle->id;
            $statuses[$idStatus] = $statusSingle->title;
        }
        $this->set(compact('statuses'));

        $sale = $this->Sales->newEmptyEntity();
        if ($this->request->is('post')) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            if ($sale->client_id) {
                if ($sale->date < $sale->date_end || $sale->date_end == null) {
                    $sale->coeficiente = $sale->devolucao / $sale->vendas;
                    $sale->economia = 0.8 * $sale->devolucao;
                    if ($this->Sales->save($sale)) {
                        $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                        $this->Sales->save($sale);
                        $this->Flash->success(__('Servi??o salvo com sucesso.'));

                        return $this->redirect(['action' => 'index']);
                    }
                    $this->Flash->error(__('O servi??o n??o foi salvo, tente novamente.'));
                }
                $this->Flash->error(__('O servi??o n??o foi salvo, verifique as datas.'));
            }
            $this->Flash->error(__('Selecione o ID do Cliente.'));
        }
        $this->set(compact('sale'));

    }

    public function edit($id = null)
    {


        $listClients = TableRegistry::get('clients');
        $listTechnicians = TableRegistry::get('users');
        $allTechnicians = $listTechnicians->find('all')->where(['role_id' => 2, 'status' => 1]);
        $technicians[0] = 'Sem T??cnico';
        foreach ($allTechnicians as $technicianSingle) {
            $idTechnician = $technicianSingle->id;
            $technicians[$idTechnician] = $technicianSingle->name;
        }
        $this->set(compact('technicians'));


        $listStatus = TableRegistry::get('statuses');
        $allStatuses = $listStatus->find('all');
        foreach ($allStatuses as $statusSingle) {
            $idStatus = $statusSingle->id;
            $statuses[$idStatus] = $statusSingle->title;
        }
        $this->set(compact('statuses'));

        $sale = $this->Sales->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            if ($sale->date < $sale->date_end || $sale->date_end == null) {
                $sale->coeficiente = $sale->devolucao / $sale->vendas;
                $sale->economia = 0.8 * $sale->devolucao;
                if ($this->Sales->save($sale)) {
                    $this->Flash->success(__('The sale has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The sale could not be saved. Please, try again.'));
            }
            $this->Flash->error(__('O servi??o n??o foi salvo, verifique as datas.'));
        }
        $this->set(compact('sale'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sale = $this->Sales->get($id);
        if ($this->Sales->delete($sale)) {
            $this->Flash->success(__('The sale has been deleted.'));
        } else {
            $this->Flash->error(__('The sale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
