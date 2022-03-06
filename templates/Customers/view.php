<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Usuários
                            </h4>
                            <div class="small text-muted">
                                Visualizar
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper my-3">
                        <div class="my-3">
                            <aside class="column">
                                <div class="side-nav">
                                    <h4 class="heading"><?= __('Ações') ?></h4>
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $customer->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $customer->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $customer->name), 'class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Usuários'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <h3><?= h($customer->name) ?></h3>
                            <table class="table">
                                <?php
                                    if (isset($clientCurrent)) {
                                        ?>
                                        <tr>
                                            <th><?= __('Cliente Associado') ?></th>
                                            <td>
                                            <?= $this->Html->link(__($clientCurrent->name), ['controller' => 'clients','action' => 'view', $clientCurrent->id], ['class' => 'side-nav-item']) ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                                <tr>
                                    <th><?= __('ID') ?></th>
                                    <td><?= $this->Number->format($customer->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Nome') ?></th>
                                    <td><?= h($customer->name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Telefone') ?></th>
                                    <td><?= h($customer->phone) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('E-mail') ?></th>
                                    <td><?= h($customer->email) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Usuário') ?></th>
                                    <td><?= h($customer->username) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
