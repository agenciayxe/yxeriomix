<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExpensesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExpensesTable Test Case
 */
class ExpensesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExpensesTable
     */
    protected $Expenses;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Expenses',
        'app.Costs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Expenses') ? [] : ['className' => ExpensesTable::class];
        $this->Expenses = TableRegistry::getTableLocator()->get('Expenses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Expenses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
