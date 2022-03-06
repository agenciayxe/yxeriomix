<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Dados de Usuários
                        </div>
                        <div class="card-body">
                            <br>
                            <table class="table table-responsive-sm table-hover table-outline mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Foto</th>
                                        <th>Usuário</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($users as $user) {
                                        $idCurrent = $user->id;
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <div class="c-avatar">
                                                    <img class="c-avatar-img" src="<?php if ($user->img) { echo $this->Url->build('/') . 'img/uploads/' . $user->img; } else  { echo $this->Url->build('/') . 'img/uploads/default.jpg'; } ?>"
                                                        alt="user@email.com">
                                                </div>
                                            </td>
                                            <td>
                                                <div><?php echo $user->name; ?></div>
                                                <div class="small text-muted">
                                                    @<?php echo $user->username; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/utils/dist/coreui-utils.js"></script>
<script src="<?php echo $this->Url->build('/'); ?>node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js"></script>
