<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TokensTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);
        $this->setTable('tokens');
        $this->setDisplayField('token');
        $this->setPrimaryKey('id');
        $this->belongsTo('Customer', [
            'foreignKey' => 'customer_id',
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
        $rules->add($rules->existsIn(['customer_id'], 'Customer'));
        return $rules;
    }
}
