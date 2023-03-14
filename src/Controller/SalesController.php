<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\FactoryLocator;

class SalesController extends AppController
{
    public function index() {
        $listTech = FactoryLocator::get('Table')->get('Users');
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
        $listLocations = FactoryLocator::get('Table')->get('Locations');
        $location = $listLocations->find('all')->where(['id' => $sale->location_id])->first();

        $this->set('sale', $sale);
        $this->set('location', $location);
    }
    public function add() {

    }
    public function addcomplete() {

        $listClients = FactoryLocator::get('Table')->get('Clients');
        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        $listTechnicians = FactoryLocator::get('Table')->get('Locations');
        $listLocations = FactoryLocator::get('Table')->get('Locations');

        $client = $listClients->newEmptyEntity();
        $sale = $this->Sales->newEmptyEntity();
        $customer = $listCustomers->newEmptyEntity();
        if ($this->request->is('post')) {
            $client = $listClients->patchEntity($client, $this->request->getData());
            $client->status_id = 1;
            $clientSave = $listClients->save($client);
            if ($clientSave) {

                $locationId = false;
                if ($this->request->getData('address') && $this->request->getData('complement')) {
                    $locations = $listLocations->newEmptyEntity();
                    $location = $listLocations->patchEntity($locations, $this->request->getData());
                    $location->client_id =  $clientSave->id;
                    $locationSave = $listLocations->save($location);
                    if ($locationSave) {
                        $locationId = $locationSave->id;
                    }
                }
                if ($locationId) {
                    if ($this->request->is('post')) {
                        $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                        $sale->client_id = $clientSave->id;
                        $sale->location_id = $locationId;
                        $sale->coeficiente = $sale->devolucao / $sale->vendas;
                        $sale->economia = 0.8 * $sale->devolucao;
                        $sale->status = 1;
                        if ($this->Sales->save($sale)) {
                            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                            $this->Sales->save($sale);

                            $customer = $listCustomers->patchEntity($customer, $this->request->getData());
                            $customer->client_id = $clientSave->id;
                            $customer->status = 1;
                            $passwordHash = new DefaultPasswordHasher();
                            $customer->password = $passwordHash->hash($customer->password);
                            $listCustomers->save($customer);

                            $this->Flash->success(__('Serviço e cliente salvo com sucesso.'));

                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('O serviço não foi salvo, tente novamente.'));
                    }
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O cliente não foi salvo, tente novamente.'));
        }
        $this->set(compact('sale'));
        $this->set(compact('client'));
    }

    public function addsale() {

        $listClients = FactoryLocator::get('Table')->get('Clients');
        $listTechnicians = FactoryLocator::get('Table')->get('Users');
        $listLocations = FactoryLocator::get('Table')->get('Locations');

        $listStatus = FactoryLocator::get('Table')->get('Statuses');
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
                $locationId = false;
                if ($this->request->getData('address') && $this->request->getData('complement')) {
                    $locations = $listLocations->newEmptyEntity();
                    $location = $listLocations->patchEntity($locations, $this->request->getData());
                    $locationSave = $listLocations->save($location);
                    if ($locationSave) {
                        $locationId = $locationSave->id;
                    }
                }
                else if ($this->request->getData('location_id')) {
                    $locationId = $this->request->getData('location_id');
                }
                if ($locationId) {
                    if ($sale->date < $sale->date_end || $sale->date_end == null) {
                        $sale->coeficiente = $sale->devolucao / $sale->vendas;
                        $sale->economia = 0.8 * $sale->devolucao;
                        $sale->location_id = $locationId;
                        $sale->status = 1;
                        if ($this->Sales->save($sale)) {
                            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
                            $this->Sales->save($sale);
                            $this->Flash->success(__('Serviço salvo com sucesso.'));

                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('O serviço não foi salvo, tente novamente.'));
                    }
                }
                $this->Flash->error(__('O serviço não foi salvo, verifique as datas.'));
            }
            $this->Flash->error(__('Selecione o ID do Cliente.'));
        }
        $this->set(compact('sale'));

    }

    public function edit($id = null)
    {


        $listClients = FactoryLocator::get('Table')->get('Clients');
        $listTechnicians = FactoryLocator::get('Table')->get('Users');
        $allTechnicians = $listTechnicians->find('all')->where(['role_id' => 2, 'status' => 1]);
        $technicians[0] = 'Sem Técnico';
        foreach ($allTechnicians as $technicianSingle) {
            $idTechnician = $technicianSingle->id;
            $technicians[$idTechnician] = $technicianSingle->name;
        }
        $this->set(compact('technicians'));


        $listStatus = FactoryLocator::get('Table')->get('Statuses');
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
            $this->Flash->error(__('O serviço não foi salvo, verifique as datas.'));
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
