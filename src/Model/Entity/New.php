<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class New extends Entity {
    protected $_accessible = [
        'title' => true,
        'content' => true,
        'img' => true,
        'date_created' => true,
        'status_id' => true,
        'status' => true,
    ];
}
