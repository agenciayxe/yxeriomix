<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SalesTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);
        $this->setTable('sales');
        $this->setDisplayField('vendas');
        $this->setPrimaryKey('id');
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id',
            'joinType' => 'INNER',
        ]);
    }
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        return $rules;
    }
}
