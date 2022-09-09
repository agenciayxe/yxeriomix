<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ImportController extends AppController
{
    public function index()
    {
        $sales = TableRegistry::get('Sales');
        $clients = TableRegistry::get('Clients');
        $locations = TableRegistry::get('Locations');
        $this->viewBuilder()->setLayout('ajax');
        $url = '../webroot/dados-site.xml';

        $h = 1;
        if (file_exists($url)) {
            $xml = simplexml_load_file($url);
            foreach ($xml->recolhimentos as $singleRecolhimentos) {

                $arrayRecolhimento = array();
                $arrayRecolhimento['name'] = (isset($singleRecolhimentos->empresa)) ? $singleRecolhimentos->empresa : '';
                $arrayRecolhimento['cpf_cnpj'] = (isset($singleRecolhimentos->cpf)) ? $singleRecolhimentos->cpf : '';
                $arrayRecolhimento['phone'] = (isset($singleRecolhimentos->telefone)) ? $singleRecolhimentos->telefone : '';
                $arrayRecolhimento['email'] = (isset($singleRecolhimentos->email)) ? $singleRecolhimentos->email : '';
                $arrayRecolhimento['status_id'] = 1;

                $arrayRecolhimento['location_id'] = 0;
                $arrayRecolhimento['vendas'] = (isset($singleRecolhimentos->qtdVendas)) ? (float) $singleRecolhimentos->qtdVendas : '';
                $arrayRecolhimento['devolucao'] = (isset($singleRecolhimentos->qtdRecolhimentos)) ? (float) $singleRecolhimentos->qtdRecolhimentos : '';
                $arrayRecolhimento['coeficiente'] = ($arrayRecolhimento['vendas'] > 0 && $arrayRecolhimento['devolucao'] > 0) ? $arrayRecolhimento['devolucao'] / $arrayRecolhimento['vendas'] : 0;
                $arrayRecolhimento['economia'] = 0.8 * $arrayRecolhimento['devolucao'];
                $arrayRecolhimento['date_buy'] = (isset($singleRecolhimentos->dataCompra)) ? date("Y-m-d H:i:s", strtotime(((string) $singleRecolhimentos->dataCompra))) : 0;
                $arrayRecolhimento['date_devolution'] = (isset($singleRecolhimentos->dataRecolhimento)) ? date("Y-m-d H:i:s", strtotime(((string) $singleRecolhimentos->dataRecolhimento))) : 0;
                $arrayRecolhimento['address'] = (isset($singleRecolhimentos->endereco)) ? $singleRecolhimentos->endereco : 0;
                $arrayRecolhimento['complement'] = (isset($singleRecolhimentos->complemento)) ? $singleRecolhimentos->complemento : 0;
                $arrayRecolhimento['status'] = 1;
                $countRecolhimento = $clients->find('all')->where(['name' => $arrayRecolhimento['name']]);

                if ($countRecolhimento->count() == 1) { $listaRecolhimentos = $countRecolhimento->first(); }
                else {$listaRecolhimentos = $clients->newEmptyEntity(); }
                $listaRecolhimentos = $clients->patchEntity($listaRecolhimentos, $arrayRecolhimento);

                if ($clients->save($listaRecolhimentos)) {
                    $arrayRecolhimento['client_id'] = $listaRecolhimentos->id;
                    $listLocations = $locations->find('all')->where(['address' => $arrayRecolhimento['address']]);
                    if ($listLocations->count() == 1) { $listLocations = $listLocations->first(); }
                    else {$listLocations = $locations->newEmptyEntity(); }
                    $listLocations = $locations->patchEntity($listLocations, $arrayRecolhimento);

                    if ($locations->save($listLocations)) {
                        $arrayRecolhimento['location_id'] = $listLocations->id;
                        $listSales = $sales->newEmptyEntity();
                        $listSales = $sales->patchEntity($listSales, $arrayRecolhimento);
                        if ($sales->save($listSales)) {

                        }
                        else {
                            print_r($arrayRecolhimento);
                        }
                    }
                }
                echo '<br>';

            }
        }
   }
}
