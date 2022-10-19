<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;

class DashboardController extends AppController
{
    public function index()
    {
        $listUsers = FactoryLocator::get('Table')->get('users');
        $listSale = FactoryLocator::get('Table')->get('sales');

        $users = $listUsers->find()->where(['status' => 1]);
        $this->set(compact('users'));
   }
}
