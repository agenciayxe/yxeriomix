<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Serviços
                            </h4>
                            <div class="small text-muted">
                                Calendário
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <form action="<?php echo $this->Url->build(['controller' => 'sales', 'action' => 'pesquisa']); ?>" class="sale-search" method="GET">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $this->Html->link(__('Adicionar Serviço'), ['action' => 'add'], ['class' => 'btn btn-pill float-right mx-1 btn-primary']) ?>
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
                                            <th>Cliente</th>
                                            <th>Datas (Venda-Devolução)</th>
                                            <th>Vendas</th>
                                            <th>Devoluções</th>
                                            <th>Coeficiente</th>
                                            <th>Economia</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($sales as $sale) {
                                        ?>
                                        <tr>
                                            <td><?= $sale->has('client') ? $this->Html->link($sale->client->name, ['controller' => 'Clients', 'action' => 'view', $sale->client->id]) : '' ?></td>
                                            <td><?= date("d/m", strtotime($sale->date_buy)) . ' - ' . date("d/m", strtotime($sale->date_devolution)); ?></td>
                                            <td><?php echo $sale->vendas; ?></td>
                                            <td><?php echo $sale->devolucao; ?></td>
                                            <td><?php echo number_format($sale->coeficiente, 2, ',', '.'); ?> (%)</td>
                                            <td>R$ <?php echo number_format($sale->economia, 2, ',', '.'); ?></td>
                                            <td>
                                                <?= $this->Html->link(__('Ver'), ['action' => 'view', $sale->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
                                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $sale->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
                                                <?php
                                                if ($usuarioAtual['role_id'] == 1) {
                                                    echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $sale->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $sale->name), 'class' => 'btn btn-pill px-2 btn-sm btn-primary side-nav-item']);
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
