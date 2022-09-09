<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Certificados
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
                                    <?= $this->Html->link(__('Certificados'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <h3><?= h($certificate->name) ?></h3>
                            <table class="table">
                                <tr>
                                    <th><?= __('Identificação') ?></th>
                                    <td>#<?= $this->Number->format($certificate->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('URL do Certificado') ?></th>
                                    <td><?= h($certificate->url) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Ver Certificado') ?></th>
                                    <td><a href="<?= h($certificate->url) ?>"><button class="btn btn-pill px-2 btn-sm btn-primary">Ver Certificado</button></a></td>
                                </tr>
                                <tr>
                                    <th><?= __('Vendas') ?></th>
                                    <td><?= h($certificate->vendas) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Devolução') ?></th>
                                    <td><?= h($certificate->devolucao) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Coeficiente') ?></th>
                                    <td><?= h($certificate->coeficiente) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Economia') ?></th>
                                    <td><?= h($certificate->economia) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Data Inicial do Certificado') ?></th>
                                    <td><?= h($certificate->date_initial) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Data Final do Certificado') ?></th>
                                    <td><?= h($certificate->date_end) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Data da Criação') ?></th>
                                    <td><?= h($certificate->date_created) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

