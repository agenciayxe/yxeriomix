<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Clientes
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
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $client->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?php
                                    if ($usuarioAtual['role_id'] == 1) {
                                        echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $client->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $client->name), 'class' => 'side-nav-item']) . ' - ';
                                    }
                                    ?>
                                    <?= $this->Html->link(__('Clientes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                </div>
                            </aside>
                        </div>
                        <div class="my-3">
                            <h3><?= h($client->name) ?></h3>
                            <table class="table">
                                <tr>
                                    <th><?= __('Identificação') ?></th>
                                    <td><?= $this->Number->format($client->id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Nome') ?></th>
                                    <td><?= h($client->name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('CPF') ?></th>
                                    <td><?= h($client->cpf_cnpj) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Telefone') ?></th>
                                    <td>
                                        <?php
                                        $telefone = $client->phone;
                                        $phoneNumber = preg_replace("/[^0-9]/", "", $client->phone);
                                        $phoneQuantity = strlen($phoneNumber);
                                        $link = ($phoneQuantity == 9 || $phoneQuantity == 11) ? 'https://api.whatsapp.com/send?phone=+55' . $phoneNumber : 'tel:+55' . $phoneNumber;
                                        ?>
                                        <a href="<?php echo $link; ?>" target="_blank"><?= h($client->phone) ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= __('Email') ?></th>
                                    <td><?= h($client->email) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Usuário') ?></th>
                                    <td><?= h($client->usarname) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Status') ?></th>
                                    <td><?= $client->has('status') ? $client->status->title : '' ?></td>
                                </tr>
                            </table>
                            <div class="related">
                                <h4 class="my-2"><?= __('Recolhimentos') ?></h4>
                                <?php if (!empty($client->sales)) : ?>
                                <div class="table-responsive">
                                    <table class="table">

                                        <thead>
                                            <tr>
                                                <th>Última Devolução</th>
                                                <th>Economia no Mês</th>
                                                <th>Economia Acumulado</th>
                                                <th class="actions"><?= __('Ações') ?></th>
                                            </tr>
                                        </thead>
                                        <?php foreach ($client->sales as $sales) : ?>
                                        <tbody>
                                            <tr class="item-36896">
                                                <td data-th="Última Devolução">
                                                    <p><?= strftime("%d/%m/%Y", strtotime($sales->date_devolution)); ?></p>
                                                </td>
                                                <td data-th="Economia no Mês">
                                                    <span class="nowrap">
                                                        R$ <?= number_format($sales->economia, 2, ',', '.') ?>
                                                    </span>
                                                </td>
                                                <td data-th="Economia Acumulado">
                                                    <span class="nowrap">
                                                        R$ <?= number_format($sales->economia_acumulado, 2, ',', '.') ?>
                                                    </span>
                                                </td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__('Ver Serviço'), ['controller' => 'Sales', 'action' => 'view', $sales->id], ['class' => 'btn btn-pill mx-1 px-5 btn-primary']) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <?php endforeach; ?>
                                    </table>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

