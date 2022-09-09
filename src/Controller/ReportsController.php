<?php
declare(strict_types=1);
namespace App\Controller;
use Cake\ORM\TableRegistry;
class ReportsController extends AppController {
    public function index() {
    }
    public function count() {

        /* -------------------- TABELAS USADAS -------------------- */
        $listClients = TableRegistry::get('clients');
        $listUsers = TableRegistry::get('users');
        $listCustomers = TableRegistry::get('customers');
        $listSale = TableRegistry::get('sales');

        /* -------------------- FORMULÁRIO GET - FILTRO -------------------- */

        $dateStart = ($this->request->getQuery('datestart')) ? strftime("%Y-%m-%d %H:%M:%S", strtotime($this->request->getQuery('datestart'))): null;
        $dateEnd = ($this->request->getQuery('dateend')) ? strftime("%Y-%m-%d %H:%M:%S", strtotime("+23 hours 59 seconds", strtotime($this->request->getQuery('dateend')))): null;
        $stampStart = ($this->request->getQuery('datestart')) ? strftime("%d/%m/%Y", strtotime($this->request->getQuery('datestart'))): null;
        $stampEnd = ($this->request->getQuery('dateend')) ? strftime("%d/%m/%Y", strtotime("+23 hours 59 seconds", strtotime($this->request->getQuery('dateend')))): null;
        $insertStart = ($this->request->getQuery('datestart')) ? strftime("%Y-%m-%d", strtotime($this->request->getQuery('datestart'))): null;
        $insertEnd = ($this->request->getQuery('dateend')) ? strftime("%Y-%m-%d", strtotime("+23 hours 59 seconds", strtotime($this->request->getQuery('dateend')))): null;
        $mensagemStamp = ($stampStart && $stampEnd) ? '' . $stampStart . ' - ' . $stampEnd . '': false;
        $this->set(compact('mensagemStamp'));
        $this->set(compact('insertStart'));
        $this->set(compact('insertEnd'));
        $mensagemPeriodo = false;
        $periodo = [];
        $periodoServicos = [];
        if ($dateStart and $dateEnd and ($dateStart <= $dateEnd)) {
            $periodo = [
                'conditions' => [
                    'OR' => [
                        [
                            'date_buy >= ' => $dateStart,
                            'date_buy <= ' => $dateEnd,
                        ],
                        [
                            'date_devolution >= ' => $dateStart,
                            'date_devolution <= ' => $dateEnd
                        ]
                    ],
                ]
            ];
            $periodoServicos = $periodo;
        }
        else if ($dateStart and $dateEnd and ($dateStart >= $dateEnd)) {
            $mensagemPeriodo = 'A data inicial deve ser antes da data final.';
        }
        $this->set(compact('mensagemPeriodo'));
        /* -------------------- MÉTRICAS -------------------- */
        $clientes = $listClients->find('all');
        $clientesQuantity = $clientes->count();
        $this->set(compact('clientesQuantity'));

        $servicos = $listSale->find('all', $periodoServicos);
        $servicosQuantity = ($servicos->count()) ? $servicos->count(): 0;
        $this->set(compact('servicosQuantity'));

        $customers = $listCustomers->find('all')->where(['status' => 1]);
        $usuariosQuantity = $customers->count();
        $this->set(compact('usuariosQuantity'));

        /* -------------------- VALORES -------------------- */
        $sales = $listSale->find('all', $periodoServicos);
        $totalVendas = 0;
        $totalDevolucoes = 0;
        $coeficiente = 0;
        $economia = 0;
        foreach ($sales as $singleService) {
            $totalVendas += $singleService->vendas;
            $totalDevolucoes += $singleService->devolucao;
            $coeficiente += $singleService->coeficiente;
            $economia += $singleService->economia;
        }
        $coeficiente = ($coeficiente != 0 && $servicosQuantity != 0) ? $coeficiente / $servicosQuantity : 0;
        $this->set(compact('totalVendas'));
        $this->set(compact('totalDevolucoes'));
        $this->set(compact('coeficiente'));
        $this->set(compact('economia'));

    }
    public function list() {
        /* -------------------- TABELAS USADAS -------------------- */
        $listClients = TableRegistry::get('clients');
        $listUsers = TableRegistry::get('users');
        $listSale = TableRegistry::get('Sales');

        $clients = $this->paginate($listClients->find('all'));
        $sales = array();
        foreach ($clients as $singleClient) {
            $idClientCurrent = $singleClient->id;
            $saleList = $listSale->find('all')->where(['client_id' => $idClientCurrent]);

            $sales[$idClientCurrent]['vendas'] = 0;
            $sales[$idClientCurrent]['devolucao'] = 0;
            $sales[$idClientCurrent]['coeficiente'] = 0;
            $sales[$idClientCurrent]['economia'] = 0;
            $saleNumber = 0;

            foreach ($saleList as $saleSingle) {
                $sales[$idClientCurrent]['vendas'] += $saleSingle->vendas;
                $sales[$idClientCurrent]['devolucao'] += $saleSingle->devolucao;
                $sales[$idClientCurrent]['coeficiente'] += $saleSingle->coeficiente;
                $sales[$idClientCurrent]['economia'] += $saleSingle->economia;
                $saleNumber++;
            }
            $sales[$idClientCurrent]['coeficiente'] = $sales[$idClientCurrent]['devolucao'] / $sales[$idClientCurrent]['vendas'];

            $sales[$idClientCurrent]['number'] = $saleNumber;
        }
        $this->set(compact('clients'));
        $this->set(compact('sales'));
    }
    public function graphics () {

        /* -------------------- TABELAS USADAS -------------------- */
        $listClients = TableRegistry::get('clients');
        $listUsers = TableRegistry::get('users');
        $listSale = TableRegistry::get('Sales');

        $arrayGraphics = array();
        for ($i = 7; $i >= -1; $i--) {

            $query_date = date('Y-m-d', strtotime(-$i . 'month'));
            $month = (int) date('n', strtotime($query_date));
            $dateStart = date('Y-m-01', strtotime($query_date));
            switch ($month) {
                case 1: $month = 'Janeiro'; break;
                case 2: $month = 'Fevereiro'; break;
                case 3: $month = 'Março'; break;
                case 4: $month = 'Abril'; break;
                case 5: $month = 'Maio'; break;
                case 6: $month = 'Junho'; break;
                case 7: $month = 'Julho'; break;
                case 8: $month = 'Agosto'; break;
                case 9: $month = 'Setembro'; break;
                case 10: $month = 'Outubro'; break;
                case 11: $month = 'Novembro'; break;
                case 12: $month = 'Dezembro'; break;
            }
            // Last day of the month.
            $dateEnd = date('Y-m-t', strtotime($query_date));
            $mensagemPeriodo = false;
            $periodo = [];
            $periodoServicos = [];
            if ($dateStart and $dateEnd and ($dateStart <= $dateEnd)) {
                $periodo = [
                    'conditions' => [
                        'OR' => [
                            [
                                'date_buy >= ' => $dateStart,
                                'date_buy <= ' => $dateEnd,
                            ],
                            [
                                'date_devolution >= ' => $dateStart,
                                'date_devolution <= ' => $dateEnd
                            ]
                        ],
                    ]
                ];
                $periodoServicos = $periodo;
            }
            else if ($dateStart and $dateEnd and ($dateStart >= $dateEnd)) {
                $mensagemPeriodo = 'A data inicial deve ser antes da data final.';
            }
            $this->set(compact('mensagemPeriodo'));

            $sales = $listSale->find('all', $periodoServicos);
            $servicosQuantity = ($sales->count()) ? $sales->count(): 0;
            $totalVendas = 0;
            $totalDevolucoes = 0;
            $coeficiente = 0;
            $economia = 0;
            foreach ($sales as $singleService) {
                $totalVendas += $singleService->vendas;
                $totalDevolucoes += $singleService->devolucao;
                $coeficiente += $singleService->coeficiente;
                $economia += $singleService->economia;
            }
            $coeficiente = ($coeficiente != 0 && $servicosQuantity != 0) ? $coeficiente / $servicosQuantity : 0;

            $arrayGraphics[$month]['totalVendas'] = $totalVendas;
            $arrayGraphics[$month]['totalDevolucoes'] = $totalDevolucoes;
            $arrayGraphics[$month]['coeficiente'] = $coeficiente;
            $arrayGraphics[$month]['economia'] = $economia;
            $arrayGraphics[$month]['quantityVendas'] = $servicosQuantity;
        }
        $this->set(compact('arrayGraphics'));
    }
}
