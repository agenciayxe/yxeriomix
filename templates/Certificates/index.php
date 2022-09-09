<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Certificados
                            </h4>
                            <div class="small text-muted">
                                Lista
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <form action="<?php echo $this->Url->build(['controller' => 'certificates', 'action' => 'pesquisa']); ?>" class="certificate-search" method="GET">
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
                                            <th>Vendas</th>
                                            <th>Devoluções</th>
                                            <th>Coeficiente</th>
                                            <th>Economia</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($certificates as $certificate) {
                                        ?>
                                            <td><?php echo $certificate->vendas; ?></td>
                                            <td><?php echo $certificate->devolucao; ?></td>
                                            <td><?php echo number_format($certificate->coeficiente, 2, ',', '.'); ?> (%)</td>
                                            <td>R$ <?php echo number_format($certificate->economia, 2, ',', '.'); ?></td>

                                            <td>
                                                <?= $this->Html->link(__('Ver Certificado'), ['action' => 'view', $certificate->id], ['class' => 'btn btn-pill px-2 btn-sm btn-primary']) ?>
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
