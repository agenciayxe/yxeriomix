<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="c-chart-wrapper my-3">
                        <div class="only-print">
                            <div class="row py-4">
                                <div class="col-md-5">
                                    <small>
                                        <p class="my-0 py-0"><strong>TELEFONE E SUPORTE</strong></p>
                                        <p class="my-0 py-0"></p>
                                    </small>
                                </div>
                                <div class="col-md-2">
                                    <img src="<?php echo $this->Url->build('/'); ?>img/logo-blue.png" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-5 text-right">
                                    <small>
                                        <p class="my-0 py-0"><strong>E-MAIL</strong></p>
                                        <p class="my-0 py-0"></p>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="main-content">
                            <!-- FLASH MESSAGE -->
                            <div class="content-divider jumbotron my-3 py-3">
                                <span class="content-divider-title">
                                <i class="fas fa-cogs"></i> ID: <?php echo '#' . $sale->os; ?>
                                </span>
                                <span class="no-print">
                                    -
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $sale->id], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?php
                                    if ($usuarioAtual['role_id'] == 1) {
                                        echo $this->Form->postLink(__('Excluir'), ['action' => 'delete', $sale->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $sale->title), 'class' => 'side-nav-item']) . ' - ';
                                    }
                                    ?>
                                    <?= $this->Html->link(__('Serviços'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                    -
                                    <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                                    <div class="clear"></div>
                                </span>
                                <p>
                                    <i class="far fa-user"></i>
                                    <?= $sale->has('client') ? $this->Html->link($sale->client->name, ['controller' => 'Clients', 'action' => 'view', $sale->client->id]) : '' ?>
                                <p>
                                    <i class="far fa-clock"></i>
                                    Data e Horário: <?= strftime("%d/%m/%Y - %H:%M", strtotime($sale->date_devolution)); ?>
                                <p>
                                    <i class="far fa-clock"></i>
                                    Endereço: <?= $location->address . ' ' . $location->complement; ?>
                                <p>
                                    <?php
                                    $telefone = $sale->client->phone;
                                    $phoneNumber = preg_replace("/[^0-9]/", "", $sale->client->phone);
                                    $phoneQuantity = strlen($phoneNumber);
                                    $link = ($phoneQuantity == 9 || $phoneQuantity == 11) ? 'https://api.whatsapp.com/send?phone=+55' . $phoneNumber : 'tel:+55' . $phoneNumber;
                                    $icon = ($phoneQuantity == 9 || $phoneQuantity == 11) ? '<i class="fab fa-whatsapp"></i>' : '<i class="fas fa-phone"></i>';
                                    ?>
                                    <?= $icon; ?> <a href="<?php echo $link; ?>" target="_blank"><?= h($sale->client->phone) ?></a>
                                <p>
                                <p>
                                    <i class="far fa-envelope"></i>
                                    <a href="mailto:<?= h($sale->client->email) ?>"><?= h($sale->client->email) ?></a>
                                <p>
                            </div>
                            <!-- ITENS -->
                            <div class="content-divider jumbotron my-3 py-3">
                                <div class="content-divider-in">
                                    <table class="ui table">
                                        <thead>
                                            <tr>
                                                <th>Última Devolução</th>
                                                <th>Data da Última Compra</th>
                                                <th>Quantidade de Vendas</th>
                                                <th>Devolução</th>
                                                <th>Coeficiente de Devolução</th>
                                                <th>Economias</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="item-36896">
                                                <td data-th="Última Devolução">
                                                    <p><?= date("d/m/Y", strtotime($sale->date_devolution)); ?></p>
                                                </td>
                                                <td data-th="Data da Compra">
                                                    <p><?= date("d/m/Y", strtotime($sale->date_buy)); ?></p>
                                                </td>
                                                <td data-th="Vendas">
                                                    <p><?php echo $sale->vendas;?></p>
                                                </td>
                                                <td data-th="Devolução">
                                                    <p><?php echo $sale->devolucao;?></p>
                                                </td>
                                                <td data-th="Coeficiente de Devolução">
                                                    <p><?php echo $sale->coeficiente;?></p>
                                                </td>
                                                <td data-th="Economia">
                                                    <span class="nowrap">
                                                        R$ <?= number_format($sale->economia, 2, ',', '.') ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <?php
                            if ($sale->detail || $sale->voltagem) {
                                ?>
                                <!-- DETAILS -->
                                <div class="content-divider jumbotron my-3 py-3">
                                    <h3>Detalhes</h3>
                                    <?php if ($sale->detail) { ?><p><?php echo $sale->detail; ?></p><?php } ?>
                                    <?php if ($sale->voltagem) { ?><p><strong>Voltagem: </strong> <?php echo $sale->voltagem; ?></p><?php } ?>
                                </div>
                                <?php
                            }
                            if ($sale->observation) {
                                ?>
                                <!-- OBSERVATIONS -->
                                <div class="content-divider jumbotron my-3 py-3">
                                    <h3>Observações</h3>
                                    <p><?php echo $sale->observation; ?></p>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="edit-item-form"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
