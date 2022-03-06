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
                                Calendário
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <form action="<?php echo $this->Url->build(['controller' => 'contacts', 'action' => 'pesquisa']); ?>" class="contact-search" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input name="s" type="text" placeholder="Pesquisar Contato" class="contact-input form-control" value="">
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-pill mx-1 px-5 btn-primary">Filtrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="c-chart-wrapper my-3">

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Telefone</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($contacts as $contact) {
                                        ?>
                                        <tr>
                                            <td><?= $contact->name; ?></td>
                                            <td><?= $contact->email; ?></td>
                                            <td><?= $contact->phone; ?></td>
                                            <td>
                                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $contact->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
                                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $contact->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
                                                <?php
                                                if ($usuarioAtual['role_id'] == 1) {
                                                    echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $contact->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $contact->nome), 'class' => 'btn btn-pill px-2 btn-sm btn-primary side-nav-item']);
                                                }
                                                ?>
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
</main>
