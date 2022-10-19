<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Controller;
use Cake\Datasource\FactoryLocator;
use Cake\Utility\Text;
use Cake\Mailer\Mailer;

class ApiController extends AppController
{
    public function initialize(): void {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
        header("Content-type:application/json");
        $this->viewBuilder()->setLayout('ajax');
    }
    public function index() {
        $response = array( 'status' => false, 'message' => 'Informe a área que deseja acessar!' );
        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function login() {
        $response = array(
            'status' => false,
            'user' => '',
            'message' => 'Houve um erro ao enviar a mensagem',
        );

        $dadosFetch = file_get_contents('php://input');
        if ($dadosFetch) {
            $dadosFetch = json_decode($dadosFetch);

            $this->request = $this->request->withData('username', $dadosFetch->username);
            $this->request = $this->request->withData('password', $dadosFetch->password);
        }

        if ($this->request->getData('username') && $this->request->getData('password')) {

            $this->loadComponent('Auth', [
                'authenticate' => [
                    'Form' => [
                        'fields' => [
                            'username' => 'username',
                            'password' => 'password'
                        ],
                        'userModel' => 'customers'
                    ],
                    'Basic' => [
                        'fields' => [ 'username' => 'username', 'password' => 'password'],
                        'userModel' => 'customers'
                    ],
                ]
            ]);

            $usuarioAtual = $this->Auth->identify();
            if ($usuarioAtual) { $response['message'] = 'Você entrou em sua conta.'; $response['user'] = $usuarioAtual; $response['status'] = true; }
            else { $response['message'] = 'Senha incorreta, tente novamente.'; }
        }
        else { $response['message'] = 'Preencha os campos corretamente para efetuar o login.'; }

        $response['token'] = '815ew6435h8t1g9819er8t1hg8b3df21ver51egr1a5sd138291r8ewf1w9e1f8';

        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function resume() {

        $listSale = FactoryLocator::get('Table')->get('Sales');

        $response = array(
            'devolucoes' => 0,
            'economia' => 0,
            'coeficiente' => 0,
            'familias' => 0,
            'servicos' => 0,
            'vendas' => 0,
            'client_id' => 0,
        );

        if ($this->request->getQuery('client_id')) {
            $clientId = $this->request->getQuery('client_id');
            $sales = $listSale->find('all')->where(['client_id' => $clientId]);
            $servicosQuantity = ($sales->count()) ? $sales->count(): 0;
            $response['servicos'] = $servicosQuantity;
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

            $response['vendas'] = $totalVendas;
            $response['devolucoes'] = $totalDevolucoes;
            $response['coeficiente'] = number_format($coeficiente, 2, ',', '.');
            $response['economia'] = 'R$ ' . number_format($economia, 2, ',', '.');
            $response['familias'] = floor($totalDevolucoes / 5000);
            $response['client_id'] = $clientId;
        }


        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function register() {
        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        $listTokens = FactoryLocator::get('Table')->get('Tokens');
        $response = array(
            'status' => false,
            'message' => 'Verifique todos os campos para continuar.',
        );
        $customer = $listCustomers->newEmptyEntity();
        if ($this->request->getQuery('name') && $this->request->getQuery('email') && $this->request->getQuery('phone') && $this->request->getQuery('username') && $this->request->getQuery('password')) {
            $name = $this->request->getQuery('name');
            $email = $this->request->getQuery('email');
            $phone = $this->request->getQuery('phone');
            $username = $this->request->getQuery('username');
            $password = $this->request->getQuery('password');

            $verifyEmail = $listCustomers->find('all')->where(['email' => $email]);
            $verifyUsername = $listCustomers->find('all')->where(['username' => $username]);
            if ($verifyEmail->count() > 0) { $response = array( 'status' => false, 'message' => 'Já existe uma conta cadastrada com este e-mail.' ); }
            else if ($verifyUsername->count() > 0) { $response = array( 'status' => false, 'message' => 'Já existe uma conta cadastrada com este nome de usuário.' ); }
            else {
                $customer = $listCustomers->patchEntity($customer, $this->request->getQuery());
                $customer->status = 0;
                $passwordHash = new DefaultPasswordHasher();
                $customer->password = $passwordHash->hash($password);

                if ($listCustomers->save($customer)) {


                    $codigoGerado = (string) rand(100000,999999);

                    $token = $listTokens->newEntity(['token' => $codigoGerado, 'status' => 1, 'customer_id' => $customer->id]);
                    if ($listTokens->save($token)) {
                        $mailer = new Mailer('default');
                        $mailer->setEmailFormat('html')->viewBuilder()->setTemplate('email');
                        $mailer->setFrom(['noreply@yxe.com.br' => 'YXE'])->setTo($email)->setSubject('Teste');
                        $mailer->deliver($codigoGerado);

                        $response = array( 'status' => true, 'message' => 'Seu cadastro foi efetuado com sucesso!', );
                    }
                }
            }
        }


        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function registerverify() {
        $response = array(
            'status' => false,
            'message' => 'O código informado não é válido',
        );

        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        $listTokens = FactoryLocator::get('Table')->get('Tokens');

        if ($this->request->getQuery('code') && $this->request->getQuery('username')) {
            $customerEmail = $this->request->getQuery('username');
            $tokenCode = $this->request->getQuery('code');

            $customer = $listCustomers->find('all')->where(['username' => $customerEmail]);
            $customerInfo = $customer->first();

            $token = $listTokens->find('all')->where(['token' => $tokenCode, 'status' => 1]);
            $tokenInfo = $token->first();

            if ($token->count() == 1 && $customerInfo->id == $tokenInfo->customer_id) {
                $tokenSave = $listTokens->get($tokenInfo->id);
                $tokenSave = $listTokens->patchEntity($tokenSave, ['status' => 0]);

                $customerSave = $listCustomers->get($customerInfo->id);
                $customerSave = $listCustomers->patchEntity($customerSave, ['status' => 1]);
                if ($listTokens->save($tokenSave) && $listCustomers->save($customerSave)) {
                    $response = array(
                        'status' => true,
                        'message' => 'Código verificado com sucesso!',
                    );
                }
            }

        }

        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function forgot() {
        $response = array(
            'status' => false,
            'message' => 'Houve um erro ao tentar recuperar a sua senha. Se o problema persistir entre em contato!',
        );

        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        $listTokens = FactoryLocator::get('Table')->get('Tokens');

        if ($this->request->getQuery('email')) {
            $customerEmail = $this->request->getQuery('email');
            $customer = $listCustomers->find('all')->where(['email' => $customerEmail]);
            $customerInfo = $customer->first();
            if ($customer->count() == 1) {

                $codigoGerado = (string) rand(100000,999999);

                $token = $listTokens->newEntity(['token' => $codigoGerado, 'status' => 1, 'customer_id' => $customerInfo->id]);
                if ($listTokens->save($token)) {
                    $mailer = new Mailer('default');
                    $mailer->setEmailFormat('html')->viewBuilder()->setTemplate('email');
                    $mailer->setFrom(['noreply@yxe.com.br' => 'YXE'])->setTo($customerEmail)->setSubject('Teste');
                    $mailer->deliver($codigoGerado);
                    $response = array(
                        'status' => true,
                        'message' => 'Enviamos o código de verificação para o seu e-mail.',
                    );
                }
                else {
                    $response = array(
                        'status' => false,
                        'message' => 'Não foi possível salvar as informações',
                    );
                }
            }
            else { $response = array( 'status' => false, 'message' => 'E-mail não encontrado em nosso sistema.', ); }

        }

        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function forgotverify() {
        $response = array(
            'status' => false,
            'message' => 'O código informado não é válido',
        );

        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        $listTokens = FactoryLocator::get('Table')->get('Tokens');

        if ($this->request->getQuery('code') && $this->request->getQuery('email')) {
            $customerEmail = $this->request->getQuery('email');
            $tokenCode = $this->request->getQuery('code');


            $customer = $listCustomers->find('all')->where(['email' => $customerEmail]);
            $customerInfo = $customer->first();

            $token = $listTokens->find('all')->where(['token' => $tokenCode, 'status' => 1]);
            $tokenInfo = $token->first();

            if ($token->count() == 1 && $customerInfo->id == $tokenInfo->customer_id) {
                $tokenSave = $listTokens->get($tokenInfo->id);
                $tokenSave = $listTokens->patchEntity($tokenSave, ['status' => 0]);
                if ($listTokens->save($tokenSave)) {
                    $response = array(
                        'status' => true,
                        'message' => 'Código verificado com sucesso!',
                    );
                }
            }

        }

        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function forgotpassword() {
        $response = array(
            'status' => false,
            'message' => 'A senha não foi atualizada, verifique a senha e tente novamente.',
        );

        $listCustomers = FactoryLocator::get('Table')->get('Customers');
        if ($this->request->getQuery('email') && $this->request->getQuery('password')) {
            $customerEmail = $this->request->getQuery('email');
            $password = $this->request->getQuery('password');


            $customer = $listCustomers->find('all')->where(['email' => $customerEmail]);
            $customerInfo = $customer->first();

            if ($customer->count() == 1) {
                $customerSave = $listCustomers->get($customerInfo->id);
                $customerSave = $listCustomers->patchEntity($customerSave, []);
                $hashPassword = new DefaultPasswordHasher();
                $password = $hashPassword->hash($password);
                $customerSave->password = $password;
                if ($listCustomers->save($customerSave)) {
                    $response = array(
                        'status' => true,
                        'message' => 'Sua senha foi salva com sucesso!',
                    );
                }
            }
        }

        $response = json_encode($response);
        $this->set(compact('response'));
    }
    public function contact() {
        $response = array(
            'status' => false,
            'message' => 'Houve um erro ao enviar a mensagem',
        );

        $listContacts = FactoryLocator::get('Table')->get('Contacts');
        $contacts = $listContacts->newEmptyEntity();

        if ($this->request->is('get')) {
            $contacts = $listContacts->patchEntity($contacts, $this->request->getQuery());
            $contacts->status_id = 1;

            if ($listContacts->save($contacts)) {
                $response['status'] = true;
                $response['message'] = 'Mensagem salva com sucesso';
            }
            else {
                $response['message'] = 'Houve um erro ao tentar enviar a mensagem, por favor tente novamente mais tarde';
            }
        }

        $response = json_encode($response);
        $this->set(compact('response'));

    }
    public function news() {
        $response = array(
            'status' => false,
            'message' => 'Houve um erro ao enviar a mensagem',
        );

        $newsTable = FactoryLocator::get('Table')->get('News');
        $pesquisa = ($this->request->getQuery('s')) ? $this->request->getQuery('s'): '';
        $news = $this->paginate($newsTable->find('all'));
        $newsArray = array();
        foreach ($news as $newSingle) {
            $newSingle->excerpt = Text::excerpt($newSingle->content, 'method', 100, '...');
            $newsArray[] = $newSingle;
        }

        $response = json_encode($newsArray);
        $this->set(compact('response'));

    }
    public function newshome() {
        $response = array(
            'status' => false,
            'message' => 'Houve um erro ao enviar a mensagem',
        );

        $newsTable = FactoryLocator::get('Table')->get('News');
        $pesquisa = ($this->request->getQuery('s')) ? $this->request->getQuery('s'): '';
        $news = $this->paginate($newsTable->find('all'));
        $newsArray = array();
        foreach ($news as $newSingle) {
            $newSingle->excerpt = Text::excerpt($newSingle->content, 'method', 100, '...');
            $newsArray[] = $newSingle;
        }

        $response = json_encode($newsArray);
        $this->set(compact('response'));

    }
    public function reciclergeral() {

        $listSale = FactoryLocator::get('Table')->get('Sales');

        $response = array(
            'devolucoes' => 0,
            'economia' => 0,
            'coeficiente' => 0,
            'familias' => 0,
            'servicos' => 0,
            'vendas' => 0,
            'client_id' => 0,
        );

        if ($this->request->getQuery('client_id')) {
            $clientId = $this->request->getQuery('client_id');
            $recicler = $listSale->find('all')->where(['client_id' => $clientId]);
            $servicosQuantity = ($recicler->count()) ? $recicler->count(): 0;
            $response['servicos'] = $servicosQuantity;
            $totalVendas = 0;
            $totalDevolucoes = 0;
            $coeficiente = 0;
            $economia = 0;
            foreach ($recicler as $singleService) {
                $totalVendas += $singleService->vendas;
                $totalDevolucoes += $singleService->devolucao;
                $coeficiente += $singleService->coeficiente;
                $economia += $singleService->economia;
            }
            $coeficiente = ($coeficiente != 0 && $servicosQuantity != 0) ? $coeficiente / $servicosQuantity : 0;

            $response['vendas'] = number_format($totalVendas, 0, ',', '.');
            $response['devolucoes'] = number_format($totalDevolucoes, 0, ',', '.');
            $response['coeficiente'] = number_format($coeficiente, 0, ',', '.');
            $response['economia'] = 'R$ ' . number_format($economia, 2, ',', '.');
            $response['familias'] = floor($totalDevolucoes / 5000);
            $response['client_id'] = $clientId;
        }


        $response = json_encode($response);
        $this->set(compact('response'));

    }
    public function reciclergrafico() {

        $listSale = FactoryLocator::get('Table')->get('Sales');

        $response = array();

        if ($this->request->getQuery('client_id')) {
            $clientId = $this->request->getQuery('client_id');

            $arrayGraphics = array();
            for ($i = 4; $i >= 0; $i--) {

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

                $sales = $listSale->find('all', $periodoServicos)->where(['client_id' => $clientId]);
                $totalDevolucoes = 0;
                foreach ($sales as $singleService) {
                    $totalDevolucoes += $singleService->devolucao;
                }

                $arrayGraphics['meses'][] = $month;
                $arrayGraphics['recolhimento'][] = $totalDevolucoes;
            }
            $recicler = $listSale->find('all')->where(['client_id' => $clientId]);
            $totalDevolucoes = 0;
            $economia = 0;
            foreach ($recicler as $singleService) {
                $totalDevolucoes += $singleService->devolucao;
                $economia += $singleService->economia;
            }

            $arrayGraphics['devolucoes'] = $totalDevolucoes;
            $arrayGraphics['economia'] = 'R$ ' . number_format($economia, 2, ',', '.');
            $arrayGraphics['familias'] = floor($totalDevolucoes / 5000);
        }
        $response = json_encode($arrayGraphics);
        $this->set(compact('response'));

    }
    public function reciclerpci() {


        $response = array();


        $response = json_encode($response);
        $this->set(compact('response'));

    }
    public function reciclermensal() {
        // Tabelas
        $listSale = FactoryLocator::get('Table')->get('Sales');
        $listClient = FactoryLocator::get('Table')->get('Clients');
        $listLocations = FactoryLocator::get('Table')->get('Locations');
        $response = array();
        // Verificar Cliente
        if ($this->request->getQuery('client_id')) {

            // Buscar Recolhimentos Pela data de compra
            $clientId = $this->request->getQuery('client_id');
            $recicler = $listSale->find('all')->where(['client_id' => $clientId])->order(['date_buy' => 'DESC']);
            $locations = $listLocations->find('all')->where(['client_id' => $clientId]);
            $arrayLocations = array();
            foreach ($locations as $singleLocations) {
                $idLocation = (int) $singleLocations->id;
                $arrayLocations[$idLocation] = $singleLocations->complement;
            }

            $month = array();

            // Loop de recolhimento
            foreach ($recicler as $singleService) {
                // Data de Compra - Efetuar Calculo
                $dateBuy = (string) $singleService->date_buy;
                $locationId = (int) $singleService->location_id;
                $dataCompra = strftime("%Y-%m-01", strtotime($dateBuy));
                $dateBuy = strftime("%m/%Y", strtotime($dateBuy));

                // Verificando se existe dados
                if (!isset($month[$dateBuy][$locationId])) {
                    $month[$dateBuy][$locationId]['vendas'] = 0;
                    $month[$dateBuy][$locationId]['devolucoes'] = 0;
                    $month[$dateBuy][$locationId]['economia_mes'] = 0;
                }

                // Adicionando dados por data
                $month[$dateBuy][$locationId]['data_compra'] = $dataCompra;
                $month[$dateBuy][$locationId]['vendas'] += $singleService->vendas;
                $month[$dateBuy][$locationId]['devolucoes'] += $singleService->devolucao;
                $month[$dateBuy][$locationId]['economia_mes'] = 0.8 * $month[$dateBuy][$locationId]['devolucoes'];

            }
            $monthReturn = array();

            // Loop de Mês
            foreach ($month as $nameMonth => $singleMonth) {

                foreach ($singleMonth as $locationIdCurrent => $locationMoth) {
                    // Tratamento dos Dados
                    $locationMoth['data_compra'] = strftime("%Y-%m-%d 23:59:59", strtotime(date("Y-m-t", strtotime($locationMoth['data_compra']))));
                    $periodo = [ 'conditions' => [ 'OR' => [ [ 'date_devolution <= ' => $locationMoth['data_compra'], ] ], ] ];
                    $acumulado = $listSale->find('all', $periodo)->where(['client_id' => $clientId, 'location_id' => $locationIdCurrent]);
                    $acumuladoVendas = 0;
                    $acumuladoDevolucoes = 0;

                    // Acumulador de Vendas
                    foreach ($acumulado as $acumuladoSingle) {
                        $acumuladoVendas += $acumuladoSingle->vendas;
                        $acumuladoDevolucoes += $acumuladoSingle->devolucao;
                    }

                    // Calculo Final
                    $acumuladoCoeficiente = $acumuladoDevolucoes / $acumuladoVendas;
                    $acumuladoFamilias = floor($acumuladoDevolucoes / 5000);
                    $acumuladoProtetometro = ($acumuladoDevolucoes / 5000);
                    $acumuladoEconomia = 0.8 * $acumuladoDevolucoes;

                    // Formatação de Dados
                    $monthReturn[] = array(
                        'name' =>  $nameMonth . ' - ' . $arrayLocations[$locationIdCurrent],
                        'location_id' => $locationIdCurrent,
                        'location_name' => $arrayLocations[$locationIdCurrent],
                        'client_id' => $clientId,
                        'date_end' => $locationMoth['data_compra'],

                        'vendas_mes' => number_format($locationMoth['vendas'], 0, ',', '.'),
                        'devolucoes_mes' => number_format($locationMoth['devolucoes'], 0, ',', '.'),
                        'economia_mes' => 'R$ ' . number_format($locationMoth['economia_mes'], 2, ',', '.'),

                        'vendas_acumulado' => number_format($acumuladoVendas, 0, ',', '.'),
                        'devolucoes_acumulado' => number_format($acumuladoDevolucoes, 0, ',', '.'),
                        'economia_acumulado' => 'R$ ' . number_format($acumuladoEconomia, 2, ',', '.'),
                        'coeficiente' => number_format($acumuladoCoeficiente, 3, ',', '.'),
                        'protetometro' => number_format($acumuladoProtetometro, 2, ',', '.'),
                        'pes' => number_format(($acumuladoProtetometro * 100), 0, ',', '.') . '%',
                        'familias' => $acumuladoFamilias,
                    );
                }
            }
            $response[] = $monthReturn;
        }
        $response = json_encode($response);
        $this->set(compact('response'));

    }
    public function gerarpdf() {

        // Tabelas
        $listSale = FactoryLocator::get('Table')->get('Sales');
        $listClient = FactoryLocator::get('Table')->get('Clients');
        $listCertificates = FactoryLocator::get('Table')->get('Certificates');
        $listLocations = FactoryLocator::get('Table')->get('Locations');
        $response = array();

        // Verificar Data
        if ($this->request->getQuery('client_id') && $this->request->getQuery('date_end') && $this->request->getQuery('location_id')) {

            // Salvar Cliente
            $clientId = $this->request->getQuery('client_id');
            $date_end = $this->request->getQuery('date_end');
            $locationId = $this->request->getQuery('location_id');

            // Procurar Cliente
            $clientInfo = $listClient->find()->where(['id' => $clientId])->first();

            // Data de Compra
            $date_initial = strftime("%Y-%m-01", strtotime(date("Y-m-t", strtotime($date_end))));
            $date_end = strftime("%Y-%m-%d", strtotime(date("Y-m-t", strtotime($date_end))));
            $date_now = strftime("%Y-%m-%d %H:%M:%S", strtotime('now'));

            // Periodo
            $periodo = [ 'conditions' => [ 'AND' => [ [ 'date_devolution >= ' => $date_initial, 'date_devolution <= ' => $date_end, ] ], ] ];

            // Pesquisa de Recolhimentos
            $recicler = $listSale->find('all', $periodo)->where(['client_id' => $clientId, 'location_id' => $locationId])->order(['date_buy' => 'DESC']);

            $monthCertificate = array();

            // Dados
            $monthCertificate['vendas'] = 0;
            $monthCertificate['devolucoes'] = 0;
            $monthCertificate['economia_mes'] = 0;
            $locais = array();
            foreach ($recicler as $singleService) {
                $monthCertificate['vendas'] += $singleService->vendas;
                $monthCertificate['devolucoes'] += $singleService->devolucao;
                $monthCertificate['economia_mes'] = 'R$ ' . number_format((0.8 * $monthCertificate['devolucoes']), 2, ',', '.');
                $locais[] = $singleService->location_id;
            }

            $monthCertificate['volume_mes'] = number_format(($monthCertificate['devolucoes'] / 100), 2, ',', '.');

            // Month Compra
            $monthReturnCertificate = array();
            $monthCertificate['data_compra'] = strftime("%Y-%m-%d 23:59:59", strtotime(date("Y-m-t", strtotime($date_initial))));
            $periodo = [ 'conditions' => [ 'OR' => [ [ 'date_devolution <= ' => $date_end, ] ], ] ];
            $acumulado = $listSale->find('all', $periodo)->where(['client_id' => $clientId, 'location_id' => $locationId])->order(['date_devolution' => 'DESC']);
            $acumuladoVendas = 0;
            $acumuladoDevolucoes = 0;
            foreach ($acumulado as $acumuladoSingle) {
                $acumuladoVendas += $acumuladoSingle->vendas;
                $acumuladoDevolucoes += $acumuladoSingle->devolucao;
            }

            // Calculo Final
            $acumuladoCoeficiente = $acumuladoDevolucoes / $acumuladoVendas;
            $acumuladoFamilias = floor($acumuladoDevolucoes / 5000);
            $acumuladoProtetometro = ($acumuladoDevolucoes / 5000);
            $acumuladoEconomia = 0.8 * $acumuladoDevolucoes;
            $acumuladoPes = $acumuladoProtetometro * 100;

            // Compilando os Dados
            $monthCertificate['name'] = $clientInfo->name;
            $monthCertificate['client_id'] = $clientInfo->id;
            $monthCertificate['data_compra'] = $date_initial;

            $monthCertificate['vendas_acumulado'] = number_format($acumuladoVendas, 0, ',', '.');
            $monthCertificate['devolucoes_acumulado'] = number_format($acumuladoDevolucoes, 0, ',', '.');
            $monthCertificate['economia_acumulado'] = 'R$ ' . number_format($acumuladoEconomia, 2, ',', '.');
            $monthCertificate['volume_acumulado'] = number_format(($acumuladoDevolucoes / 100), 2, ',', '.');
            $monthCertificate['coeficiente'] = number_format($acumuladoCoeficiente, 3, ',', '.');
            $monthCertificate['protetometro'] = number_format($acumuladoProtetometro, 2, ',', '.');
            $monthCertificate['familias'] = $acumuladoFamilias;
            $monthCertificate['pes'] = number_format($acumuladoPes, 0, ',', '.');

            $monthCertificate['date_initial'] = strftime("01/%m/%Y", strtotime($date_initial));
            $monthCertificate['date_slug'] = strftime("%Y-%m-01", strtotime($date_initial));
            $monthCertificate['date_end'] = strftime("%d/%m/%Y", strtotime($date_end));

            $locations = $listLocations->find('all')->where(['id' => $locationId]);
            foreach ($locations as $singleLocations) {
                $monthCertificate['location'] = $singleLocations->address . ' (' . $singleLocations->complement . ')';
            }

            // Verificando Certificado
            $searchCertificate = $listCertificates->find('all')->where(['client_id' => $clientId, 'date_initial' =>  $date_initial]);
            $searchCertificateQuantity = ($searchCertificate->count()) ? $searchCertificate->count(): 0;

            $monthCertificate['request'] = "vendas=" . $monthCertificate['vendas'] . "&devolucoes=" . $monthCertificate['devolucoes'] . "&economia_mes=" . $monthCertificate['economia_mes'] . "&volume_mes=" . $monthCertificate['volume_mes'] . "&data_compra=" . $monthCertificate['data_compra'] . "&name=" . urlencode($monthCertificate['name']) . "&client_id=" . $monthCertificate['client_id'] . "&vendas_acumulado=" . $monthCertificate['vendas_acumulado'] . "&devolucoes_acumulado=" . $monthCertificate['devolucoes_acumulado'] . "&economia_acumulado=" . $monthCertificate['economia_acumulado'] . "&volume_acumulado=" . $monthCertificate['volume_acumulado'] . "&coeficiente=" . $monthCertificate['coeficiente'] . "&protetometro=" . $monthCertificate['protetometro'] . "&familias=" . $monthCertificate['familias'] . "&pes=" . $monthCertificate['pes'] . "&date_initial=" . $monthCertificate['date_initial'] . "&date_slug=" . $monthCertificate['date_slug'] . "&date_end=" . $monthCertificate['date_end'] . "&location=" . urlencode($monthCertificate['location']);

            // Gerando PDF
            $curl = curl_init("https://yxe.com.br/sites/riomix-pdf/");
            curl_setopt($curl, CURLOPT_URL,"https://yxe.com.br/sites/riomix-pdf/");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $monthCertificate['request']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $urlCurrent = curl_exec($curl);
            $fileArray = json_decode($urlCurrent);
            $monthCertificate['file_url'] = $fileArray->file_url;
            $monthCertificate['file_name'] = $fileArray->file_name;

            // Nenhum Certificado
            if ($searchCertificateQuantity == 0) {
                // Dados
                $certificate = $listCertificates->newEmptyEntity();
                $certificate = $listCertificates->patchEntity($certificate, $this->request->getData());

                // Certificados Salvo
                $certificate->url = $monthCertificate['file_url'];
                $certificate->client_id = $clientId;
                $certificate->vendas = $monthCertificate['vendas'];
                $certificate->devolucao = $monthCertificate['devolucoes'];
                $certificate->coeficiente = $monthCertificate['coeficiente'];
                $certificate->economia = $monthCertificate['economia_mes'];
                $certificate->date_initial = $date_initial;
                $certificate->date_end = $date_end;
                $certificate->date_created = $date_now;
                $certificateSave = $listCertificates->save($certificate);
                // Salvar
                if ($certificateSave) {
                    $certificateId = $certificateSave->id;
                    $monthCertificate['id'] = $certificateId;
                }

            }
            else if ($searchCertificateQuantity == 1) {
                foreach ($searchCertificate as $singleSearchCertificate) {
                    $certificate = $listCertificates->get($singleSearchCertificate->id);
                    $certificate = $listCertificates->patchEntity($certificate, $this->request->getData());

                    $certificate->url = $monthCertificate['file_url'];
                    $certificate->client_id = $clientId;
                    $certificate->vendas = $monthCertificate['vendas'];
                    $certificate->devolucao = $monthCertificate['devolucoes'];
                    $certificate->coeficiente = $monthCertificate['coeficiente'];
                    $certificate->economia = $monthCertificate['economia_mes'];
                    $certificate->date_initial = $date_initial;
                    $certificate->date_end = $date_end;
                    $certificate->date_created = $date_now;
                    $certificateSave = $listCertificates->save($certificate);
                    if ($certificateSave) {
                        $certificateId = $certificateSave->id;
                        $monthCertificate['id'] = $certificateId;
                    }
                }
            }
            else { $monthCertificate = ''; }
            $response[] = $monthCertificate;
        }
        $response = json_encode($response);
        $this->set(compact('response'));
    }
}
