<main class="c-main">
    <div class="container-fluid">
        <div class="fade-in">
            <!-- /.row-->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title mb-0">
                                Relatórios
                            </h4>
                            <div class="small text-muted">
                                Tipos
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="row my-3">
                            <?php
                            if ($usuarioAtual['role_id'] == 1 || $usuarioAtual['role_id'] == 3) {
                                ?>
                                <div class="col-md-6">
                                    <a href="<?= $this->Url->build(['action' => 'count'], ['class' => 'btn mx-1 float-right']) ?>">
                                        <div class="jumbotron">
                                            <div class="p-2 text-center">
                                                <i class="fas fa-shopping-cart fa-3x"></i>
                                                <h3 class="my-2"><strong>Cálculo de Resultados</strong></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            if ($usuarioAtual['role_id'] == 1 || $usuarioAtual['role_id'] == 3) {
                                ?>
                                <div class="col-md-6">
                                    <a href="<?= $this->Url->build(['action' => 'graphics'], ['class' => 'btn mx-1 float-right']) ?>">
                                        <div class="jumbotron">
                                            <div class="p-2 text-center">
                                                <i class="fas fa-chart-bar fa-3x"></i>
                                                <h3 class="my-2"><strong>Relatórios em Gráfico</strong></h3>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-6">
                                <a href="<?= $this->Url->build(['action' => 'list'], ['class' => 'btn mx-1 float-right']) ?>">
                                    <div class="jumbotron">
                                        <div class="p-2 text-center">
                                            <i class="fas fa-list fa-3x"></i>
                                            <h3 class="my-2"><strong>Relatórios em Lista</strong></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
