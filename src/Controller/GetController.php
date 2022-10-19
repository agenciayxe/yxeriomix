<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;

class GetController extends AppController
{
    public function index()
    {
        $pesquisa = $this->request->getQuery('s');
        $this->paginate = [
            'contain' => ['Clients', 'Situations']
        ];
        $sales = $this->paginate($salesTable->find('all', ['conditions' => ['Sales.title  LIKE' => '%' . $pesquisa . '%']]));
        $this->set(compact('sales'));
        $this->set(compact('pesquisa'));
    }
    public function sales()
    {
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');
        $listSales = array();
        $salesTable = FactoryLocator::get('Table')->get('Sales');
        $sales = $salesTable->find('all')->contain(['Clients'])->where(['date_devolution >= ' => $start])->andWhere(['date_devolution <= ' => $end]);
        $this->set(compact('sales'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function editsale()
    {
        $responseSale = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $salesTable = FactoryLocator::get('Table')->get('Sales');
        $sale = $salesTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $date = $this->request->getData('date');
            $sale = $salesTable->patchEntity($sale, $this->request->getData());
            $sale->date = strftime("%Y-%m-%d %H:%M:%S", strtotime($date));
            if ($salesTable->save($sale)) {
                $responseSale = [
                    'response' => 'A data da venda foi atualizada com sucesso.',
                    'status' => true
                ];
            } else {
                $responseSale['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseSale['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseSale'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function leads()
    {
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');
        $listLeads = array();
        $leadsTable = FactoryLocator::get('Table')->get('Leads');
        $leads = $leadsTable->find('all')->where(['date >= ' => $start])->andWhere(['date <= ' => $end]);
        $this->set(compact('leads'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function editlead()
    {
        $responseLead = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $leadsTable = FactoryLocator::get('Table')->get('Leads');
        $lead = $leadsTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $date = $this->request->getData('date');
            $lead = $leadsTable->patchEntity($lead, $this->request->getData());
            $lead->date = strftime("%Y-%m-%d %H:%M:%S", strtotime($date));
            if ($leadsTable->save($lead)) {
                $responseLead = [
                    'response' => 'A data da venda foi atualizada com sucesso.',
                    'status' => true
                ];
            } else {
                $responseLead['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseLead['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseLead'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function searchclient()
    {
        $pesquisa = $this->request->getQuery('term');
        $clientsTable = FactoryLocator::get('Table')->get('Clients');
        $clients = $this->paginate($clientsTable->find('all', [
            'conditions' => [
                'OR' => [
                    'Clients.name LIKE' => '%' . $pesquisa . '%',
                    'Clients.email LIKE' => '%' . $pesquisa . '%',
                    'Clients.cpf_cnpj LIKE' => '%' . $pesquisa . '%',
                    'Clients.phone LIKE' => '%' . $pesquisa . '%',
                ]
            ]
        ]));
        $this->set(compact('clients'));
        $this->viewBuilder()->setLayout('ajax');
    }

    public function searchlocation()
    {
        $pesquisa = $this->request->getQuery('term');
        $clientId = $this->request->getQuery('clientId');
        if ($clientId) {
            $locationsTable = FactoryLocator::get('Table')->get('Locations');
            $locations = $this->paginate($locationsTable->find('all', [
                'conditions' => [
                    'AND' => [
                        'Locations.address LIKE' => '%' . $pesquisa . '%'
                    ]
                ]
            ])->where(['client_id' => $clientId]));
            $this->set(compact('locations'));
        }
        $this->viewBuilder()->setLayout('ajax');
    }
    public function savestatus()
    {
        $responseSale = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $salesTable = FactoryLocator::get('Table')->get('Sales');
        $sale = $salesTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $value = $this->request->getData('value');
            $field = $this->request->getData('field') . '_id';
            $sale = $salesTable->patchEntity($sale, $this->request->getData());
            $sale->$field = $value;
            if ($salesTable->save($sale)) {
                $this->Flash->success(__('Os dados foram atualizados com sucesso'));
                $responseSale = [
                    'response' => 'O status da venda foi atualizado com sucesso.',
                    'status' => true
                ];
            } else {
                $responseSale['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseSale['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseSale'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function savecosts()
    {
        $responseSale = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $costsTable = FactoryLocator::get('Table')->get('Costs');
        $cost = $costsTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $value = $this->request->getData('value');
            $field = $this->request->getData('field') . '_id';
            $cost = $costsTable->patchEntity($cost, $this->request->getData());
            $cost->$field = $value;
            if ($costsTable->save($cost)) {
                $this->Flash->success(__('Os dados foram atualizados com sucesso'));
                $responseSale = [
                    'response' => 'O status da venda foi atualizado com sucesso.',
                    'status' => true
                ];
            } else {
                $responseSale['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseSale['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseSale'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function costs()
    {
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');
        $listCosts = array();
        $CostsTable = FactoryLocator::get('Table')->get('Costs');
        $costs = $CostsTable->find('all')->where(['date >= ' => $start])->andWhere(['date <= ' => $end]);
        $this->set(compact('costs'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function editcost()
    {
        $responseCost = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $costsTable = FactoryLocator::get('Table')->get('Costs');
        $cost = $costsTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $date = $this->request->getData('date');
            $cost = $costsTable->patchEntity($cost, $this->request->getData());
            $cost->date = strftime("%Y-%m-%d", strtotime($date));
            if ($costsTable->save($cost)) {
                $responseCost = [
                    'response' => 'A data da venda foi atualizada com sucesso.',
                    'status' => true
                ];
            } else {
                $responseCost['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseCost['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseCost'));
        $this->viewBuilder()->setLayout('ajax');
    }
    // RECEIPT
    public function savereceipts()
    {
        $responseSale = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $receiptsTable = FactoryLocator::get('Table')->get('Receipts');
        $receipt = $receiptsTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $value = $this->request->getData('value');
            $field = $this->request->getData('field') . '_id';
            $receipt = $receiptsTable->patchEntity($receipt, $this->request->getData());
            $receipt->$field = $value;
            if ($receiptsTable->save($receipt)) {
                $this->Flash->success(__('Os dados foram atualizados com sucesso'));
                $responseSale = [
                    'response' => 'O status da venda foi atualizado com sucesso.',
                    'status' => true
                ];
            } else {
                $responseSale['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseSale['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseSale'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function receipts()
    {
        $start = $this->request->getQuery('start');
        $end = $this->request->getQuery('end');
        $listReceipts = array();
        $ReceiptsTable = FactoryLocator::get('Table')->get('Receipts');
        $receipts = $ReceiptsTable->find('all')->where(['date >= ' => $start])->andWhere(['date <= ' => $end]);
        $this->set(compact('receipts'));
        $this->viewBuilder()->setLayout('ajax');
    }
    public function editreceipt()
    {
        $responseReceipt = [
            'response' => 'Houve algum erro, tente novamente mais tarde!',
            'status' => false
        ];
        $id = $this->request->getData('id');
        $receiptsTable = FactoryLocator::get('Table')->get('Receipts');
        $receipt = $receiptsTable->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $date = $this->request->getData('date');
            $receipt = $receiptsTable->patchEntity($receipt, $this->request->getData());
            $receipt->date = strftime("%Y-%m-%d", strtotime($date));
            if ($receiptsTable->save($receipt)) {
                $responseReceipt = [
                    'response' => 'A data da venda foi atualizada com sucesso.',
                    'status' => true
                ];
            } else {
                $responseReceipt['response'] = 'A venda não foi atualizado, tente novamente.';
            }
        } else {
            $responseReceipt['response'] = 'Houve algum erro ao tentar atualizar a venda.';
        }
        $this->set(compact('responseCost'));
        $this->viewBuilder()->setLayout('ajax');
    }
}
