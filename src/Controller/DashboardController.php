<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class DashboardController extends AppController
{
    public function index()
    {
        $listUsers = TableRegistry::get('users');
        $listSale = TableRegistry::get('sales');

        $users = $listUsers->find()->where(['status' => 1]);
        $this->set(compact('users'));
   }
}
