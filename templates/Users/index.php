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
                                Lista
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper my-3">
                        <div class="main-action text-right">
                            <?= $this->Html->link(__('Adicionar Técnico'), ['action' => 'add'], ['class' => 'btn btn-pill mx-1 my-3 px-5 btn-primary']) ?>
                        </div>
                        <div class="main-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Técnicos</th>
                                                <th>Usuário</th>
                                                <th>Função</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($users as $user) {
                                            ?>
                                            <tr>
                                                <td><?= h($user->name) ?></td>
                                                <td><?= h($user->username) ?></td>
                                                <td><?= $user->has('role') ? $user->role->name : '' ?></td>
                                                <td>
                                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
                                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
                                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $user->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $user->name), 'class' => 'btn btn-pill px-2 btn-sm btn-primary side-nav-item']) ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="paginator">
                                <ul class="col-md-12 pagination">
                                    <?= $this->Paginator->first('<< ' . __('Primeira')) ?>
                                    <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next(__('Próxima') . ' >') ?>
                                    <?= $this->Paginator->last(__('Última') . ' >>') ?>
                                </ul>
                                <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} resultados de {{count}} no total')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
