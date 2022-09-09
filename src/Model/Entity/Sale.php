<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Sale extends Entity {
    protected $_accessible = [
        'id' => true,
        'client_id' => true,
        'location_id' => true,
        'vendas' => true,
        'devolucao' => true,
        'coeficiente' => true,
        'economia' => true,
        'date_buy' => true,
        'date_devolution' => true,
        'status' => true,
    ];
}
