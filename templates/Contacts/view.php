<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Contatos
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
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $contact->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $contact->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $contact->name), 'class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Usuários'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <h3><?= h($contact->number) ?></h3>
                            <table class="table">
                                <tr>
                                    <th><?= __('Idendificação') ?></th>
                                    <td><?= $this->Number->format($contact->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Nome') ?></th>
                                    <td><?= h($contact->name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('E-mail') ?></th>
                                    <td><?= h($contact->email) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Telefone') ?></th>
                                    <td><?= h($contact->phone) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Data') ?></th>
                                    <td><?= date("d/m/Y", strtotime($contact->date_created)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
