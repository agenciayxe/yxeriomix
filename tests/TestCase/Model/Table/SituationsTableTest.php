<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SituationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SituationsTable Test Case
 */
class SituationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SituationsTable
     */
    protected $Situations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Situations',
        'app.Services',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Situations') ? [] : ['className' => SituationsTable::class];
        $this->Situations = TableRegistry::getTableLocator()->get('Situations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Situations);

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
