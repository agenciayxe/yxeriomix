<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
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

        $listSale = TableRegistry::get('sales');

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
        $listCustomers = TableRegistry::get('customers');
        $listTokens = TableRegistry::get('tokens');
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

        $listCustomers = TableRegistry::get('customers');
        $listTokens = TableRegistry::get('tokens');

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

        $listCustomers = TableRegistry::get('customers');
        $listTokens = TableRegistry::get('tokens');

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

        $listCustomers = TableRegistry::get('customers');
        $listTokens = TableRegistry::get('tokens');

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

        $listCustomers = TableRegistry::get('customers');
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

        $listContacts = TableRegistry::get('contacts');
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

        $newsTable = TableRegistry::get('News');
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

        $newsTable = TableRegistry::get('News');
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
    public function reciclerindividual() {

        $listSale = TableRegistry::get('sales');
        $listClient = TableRegistry::get('clients');
        $response = array();
        if ($this->request->getQuery('client_id')) {
            $clientId = $this->request->getQuery('client_id');
            $recicler = $listSale->find('all')->where(['client_id' => $clientId]);

            $clientInfo = $listClient->find()->where(['id' => $clientId])->first();
            foreach ($recicler as $reciclerSingle) {

                $dateBuy = (string) $reciclerSingle->date_buy;
                $reciclerSingle->date_buy = strftime("%d/%m/%Y", strtotime($dateBuy));

                $dateDevolution = (string) $reciclerSingle->date_devolution;
                $reciclerSingle->date_devolution = strftime("%d/%m/%Y", strtotime($dateDevolution));

                $reciclerSingle->coeficiente = number_format($reciclerSingle->coeficiente, 3, ',', '.');

                $reciclerSingle->client_name = $clientInfo->name;

                $reciclerSingle->economia = 'R$ ' . number_format($reciclerSingle->economia, 2, ',', '.');
                $response[] = $reciclerSingle;
            }
        }
        $response = json_encode($response);
        $this->set(compact('response'));

    }
    public function reciclergeral() {

        $listSale = TableRegistry::get('sales');

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

            $response['vendas'] = $totalVendas;
            $response['devolucoes'] = $totalDevolucoes;
            $response['coeficiente'] = $coeficiente;
            $response['economia'] = $economia;
            $response['familias'] = floor($totalDevolucoes / 5000);
            $response['client_id'] = $clientId;
        }


        $response = json_encode($response);
        $this->set(compact('response'));

    }
    public function reciclergrafico() {

        $listSale = TableRegistry::get('sales');

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

}
