<?php
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

$cakeDescription = 'Riomix - Login';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="?ukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>
        <?= $cakeDescription ?>
    </title>
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <link rel="manifest" href="<?php echo $this->Url->build('/'); ?>assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $this->Url->build('/'); ?>img/logo-minimized.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Main styles for this application-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
    <link href="node_modules/@coreui/coreui/dist/css/coreui.min.css" rel="stylesheet">
    <link href="node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css" rel="stylesheet">
</head>
<body class="c-app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-4">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">

                            <div class="text-center pb-3">
                                <img src="img/logo-blue.png" style="max-width: 200px" class="img-fluid" alt="">
                            </div>
                            <form action="<?php echo $this->Url->Build(['controller' => 'login', 'action' => 'index']); ?>" method="POST">
                                <h1>Entrar</h1>
                                <p class="text-muted">Entre em sua conta</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
                                            </svg></span></div>
                                    <input class="form-control" name="username" type="text" placeholder="Usuário">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend"><span class="input-group-text">
                                            <svg class="c-icon">
                                                <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-lock-locked"></use>
                                            </svg></span></div>
                                    <input class="form-control" name="password" type="password" placeholder="Senha">
                                </div>
                                <input type="hidden" name="_csrfToken" value="<?php echo $this->request->getAttribute('csrfToken'); ?>">
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary px-4" type="submit">Entrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                $render = $this->Flash->render();
                if ($render) {
                    ?>
                    <div class="container-fluid my-3"><div class="alert alert-warning" role="alert"><?php echo $render; ?></div></div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js"></script>
    <!--[if IE]><!-->
    <script src="node_modules/@coreui/icons/js/svgxuse.min.js"></script>
    <!--<![endif]-->
</body>
</html>
