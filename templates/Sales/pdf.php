<section class="content-title">
    <div class="container">
        <h1>Serviços</h1>
    </div>
</section>
<main class="page-clients">
    <div class="container">

        <div class="main-content">
            <!-- FLASH MESSAGE -->
            <div class="content-divider jumbotron my-3 py-3">
                <span class="content-divider-title">
                    <?php echo '#' . $service->client->id; ?>
                </span>
                -
                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $service->id], ['class' => 'side-nav-item']) ?>
                -
                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $service->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $service->title), 'class' => 'side-nav-item']) ?>
                -
                <?= $this->Html->link(__('Serviços'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                -
                <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                <div class="clear"></div>

                <p>
                    <i class="far fa-user"></i>
                    <?= $service->has('client') ? $this->Html->link($service->client->nome . ' - ' . $service->client->cpf, ['controller' => 'Clients', 'action' => 'view', $service->client->id]) : '' ?>
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    <?php 
                    $detailAddress = array(
                        $service->client->address,
                        $service->client->reference,
                        $service->client->district,
                        $service->client->city,
                        $service->client->state,
                        
                    );
                    $addressComplete = implode(',', $detailAddress); ?>
                    <a target="_blank" href="http://maps.google.com/?q=<?php echo $addressComplete; ?>"><?php echo $addressComplete; ?></a></p>
                <p>
                    <i class="far fa-clock"></i>
                    Data e Horário: <?= strftime("%d/%m/%Y - %H:%M", strtotime($service->date)); ?>

                <p>
                    <?php
                    $telefone = $service->client->phone;
                    $phoneNumber = preg_replace("/[^0-9]/", "", $service->client->phone);
                    $phoneQuantity = strlen($phoneNumber);
                    $link = ($phoneQuantity == 9 || $phoneQuantity == 11) ? 'https://api.whatsapp.com/send?phone=+55' . $phoneNumber : 'tel:+55' . $phoneNumber;
                    $icon = ($phoneQuantity == 9 || $phoneQuantity == 11) ? '<i class="fab fa-whatsapp"></i>' : '<i class="fas fa-phone"></i>';
                    ?>
                    <?= $icon; ?> <a href="<?php echo $link; ?>" target="_blank"><?= h($service->client->phone) ?></a>
                <p>
                <p>
                    <i class="far fa-envelope"></i>
                    <a href="mailto:<?= h($service->client->email) ?>"><?= h($service->client->email) ?></a>
                <p>
                <p><i class="flag fab"></i>
                <?php 
                switch ($service->situation->id) {
                    case 1: $color = 'warning'; break; 
                    case 2: $color = 'danger'; break;
                    case 3: $color = 'success'; break;
                    case 4: $color = 'danger'; break;
                    case 5: $color = 'warning'; break;
                    case 6: $color = 'warning'; break;
                    case 7: $color = 'primary'; break;
                    default; $color = 'primary'; break;
                }
                ?>
                    <span class="badge badge-<?php echo $color; ?>"><?php echo $service->situation->title; ?></span></p>

                <?= $this->Html->link(__('Imprimir Ordem'), ['action' => 'add'], ['class' => 'btn mt-3']) ?>
                <a href="<?php echo $this->Url->build(['controller' => 'services', 'action' => 'rotas']); ?>?datestart=<?= strftime("%Y-%m-%d", strtotime($service->date)); ?>&technician_id=<?php echo $service->technician_id; ?>"><button class="btn mt-3">Ver na Rota ZAP</button></a>

            </div>

            <!-- ITENS -->
            <div class="content-divider jumbotron my-3 py-3">
                <div class="content-divider-in">
                    <table class="ui table">
                        <thead>
                            <tr>
                                <th>Serviço/Produto</th>
                                <th>Valor Unit.</th>
                                <th>Qtd</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="item-36896">
                                <td data-th="Serviço/Produto">
                                    <p><b><?php echo $service->title;?></b></p>
                                </td>
                                <td width="15%" data-th="Valor Unit.">
                                    <span class="nowrap">
                                        R$ <?= number_format($service->price, 2, ',', '.') ?>
                                    </span>
                                </td>
                                <td data-th="Qtd">1</td>
                                <td width="15%" data-th="Total">
                                    <span class="nowrap">
                                        R$ <?= number_format($service->price, 2, ',', '.') ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div align="right" class="order-money-totals">
                        <p><b>Sub Total:</b> R$ <span class="subtotal"><?= number_format($service->price, 2, ',', '.') ?></span></p>
                        <p><b>Desconto:</b> <span>R$ 0,00</span></p>
                        <p><b>Total:</b> R$ <span class="total"><?= number_format($service->price, 2, ',', '.') ?></span></p>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <!-- OBSERVATIONS -->
            <div class="content-divider jumbotron my-3 py-3">
                <h3>Detalhes</h3>
                <p><?php echo $service->observation; ?></p>
            </div>

            <div class="edit-item-form"></div>
        </div>




        <?php /* ?>
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <aside class="column">
                            <div class="side-nav">
                                <h4 class="heading"><?= __('Ações') ?></h4>
                                <?= $this->Html->link(__('Editar'), ['action' => 'edit', $service->id], ['class' => 'side-nav-item']) ?>
                                -
                                <?= $this->Form->postLink(__('Excluir'), ['action' => 'delete', $service->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $service->title), 'class' => 'side-nav-item']) ?>
                                -
                                <?= $this->Html->link(__('Serviços'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
                                -
                                <?= $this->Html->link(__('Adicionar Novo'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                            </div>
                        </aside>
                    </div>
                    <div class="my-3">
                        <h3>Dados do Cliente</h3>
                        <table class="table">
                            <tr>
                                <th><?= __('Nome') ?></th>
                                <td><?= h($service->client->nome) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('CPF') ?></th>
                                <td><?= h($service->client->cpf) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Endereço') ?></th>
                                <td><?= h($service->client->address) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Bairro') ?></th>
                                <td><?= h($service->client->district) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Cidade') ?></th>
                                <td><?= h($service->client->city) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Referência') ?></th>
                                <td><?= h($service->client->reference) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Telefone') ?></th>
                                <td>
                                    <?php
                                    $telefone = $service->client->phone;
                                    $phoneNumber = preg_replace("/[^0-9]/", "", $service->client->phone);
                                    $phoneQuantity = strlen($phoneNumber);
                                    $link = ($phoneQuantity == 9 || $phoneQuantity == 11) ? 'https://api.whatsapp.com/send?phone=+55' . $phoneNumber : 'tel:+55' . $phoneNumber;
                                    ?>
                                    <a href="<?php echo $link; ?>" target="_blank"><?= h($service->client->phone) ?></a>
                                </td>
                            </tr>
                            <tr>
                                <th><?= __('Email') ?></th>
                                <td><?= h($service->client->email) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Status') ?></th>
                                <td><?= ($service->client->status->title) ? $service->client->status->title : '' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="my-3">
                        <h3>Dados do Serviço</h3>
                        <table class="table">
                            <tr>
                                <th><?= __('Ordem de Serviço') ?></th>
                                <td><?= $this->Number->format($service->id) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Serviço') ?></th>
                                <td><?= h($service->title) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Cliente') ?></th>
                                <td><?= $service->has('client') ? $this->Html->link($service->client->nome, ['controller' => 'Clients', 'action' => 'view', $service->client->id]) : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Situação') ?></th>
                                <td><?= $service->has('situation') ? $service->situation->title : '' ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Data do Serviço') ?></th>
                                <td><?= strftime("%d/%m/%Y - %H:%M", strtotime($service->date)); ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Observação') ?></th>
                                <td><?= $service->observation; ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Valor') ?></th>
                                <td><?= $this->Number->format($service->price) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        */ ?>
    </div>
</main>