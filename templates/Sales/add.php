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
                                Adicionar
                            </div>
                        </div>
                    </div>

                    <div class="c-chart-wrapper my-3">
                        <div class="row my-3">
                            <div class="col-md-6">
                                <a href="<?= $this->Url->build(['action' => 'addsale'], ['class' => 'btn mx-1 float-right']) ?>">
                                    <div class="jumbotron">
                                        <div class="p-2 text-center">
                                            <i class="fas fa-address-book fa-3x"></i>
                                            <h3 class="my-2"><strong>Cliente Existente</strong></h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="<?= $this->Url->build(['action' => 'addcomplete'], ['class' => 'btn mx-1 float-right']) ?>">
                                    <div class="jumbotron">
                                        <div class="p-2 text-center">
                                            <i class="fas fa-user-plus fa-3x"></i>
                                            <h3 class="my-2"><strong>Novo Cliente</strong></h3>
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
