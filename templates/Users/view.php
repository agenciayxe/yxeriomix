<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Administradores
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
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $user->name), 'class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Usuários'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <h3><?= h($user->name) ?></h3>
                            <table class="table">
                                <tr>
                                    <th><?= __('Idendificação') ?></th>
                                    <td><?= $this->Number->format($user->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Nome') ?></th>
                                    <td><?= h($user->name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Usuário') ?></th>
                                    <td><?= h($user->username) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Função') ?></th>
                                    <td><?= $user->has('role') ? $user->role->name : '' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
