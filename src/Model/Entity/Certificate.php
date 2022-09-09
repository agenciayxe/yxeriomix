<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Certificate extends Entity {
    protected $_accessible = [
        'id' => true,
        'client_id' => true,
        'vendas' => true,
        'url' => true,
        'devolucao' => true,
        'coeficiente' => true,
        'economia' => true,
        'date_initial' => true,
        'date_end' => true,
        'date_created' => true
    ];
}
