<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Routing\Router;
use Cake\Utility\Inflector;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Estágio 2017 | <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('material-icons.css') ?>
    <?= $this->Html->css('materialize.css') ?>
    <?= $this->Html->css('/js/jquery.datetimepicker.css') ?>
    <?= $this->Html->css('/js/select2/css/select2.min.css') ?>
    <?= $this->Html->css('/js/select2/css/select2-materialize.css') ?>
    <script type="text/javascript"> var base_url = '<?= $base_url; ?>'; </script>
    <?= $this->Html->script('jquery-3.2.1.min.js') ?>
    <?= $this->Html->script('materialize.min.js') ?>
    <?= $this->Html->script('jquery.datetimepicker.min.js') ?>
    <?= $this->Html->script('jquery.mask.min.js') ?>
    <?= $this->Html->script('select2/js/select2.min.js') ?>
    <?= $this->Html->script('select2/js/i18n/pt-BR.js') ?>
    <?= $this->Html->script('scripts.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
	<header>
		<nav>
			<div class="nav-wrapper">
                <div id="expandir-menu" class="waves-effect waves-light"><?= $this->Gus->materialIcon('menu'); ?></div>
				<div class="brand-logo"><?= $this->fetch('title'); ?></div>
				<ul id="nav-links" class="right">
<!--					<li><a href="#">Links</a></li>-->
<!--					<li><a href="#">Uteis</a></li>-->
<!--					<li><a href="#">Depois</a></li>-->
<!--					<li><a href="#">Vejo</a></li>-->
				</ul>
			</div>
		</nav>
		<ul class="side-nav fixed hide-on-med-and-down">
            <li class="logo">
                <a id="logo-container" href="<?= Router::url(['controller' => 'users', 'action' => 'dashboard']); ?>" class="brand-logo" title="Clique aqui para ir ao painel">
                <?= $this->Html->image('recanto.svg', ['alt' => 'Logomarca do Recanto do Peixe']); ?>
                </a>
                <div class="nav-separator"></div>
            </li>
            <li><a href="<?= Router::url(['controller' => 'usuarios', 'action' => 'dashboard']); ?>" class="collapsible-header">Painel</a></li>
            <li>
                <ul class="collapsible collapsible-accordion">
                    <?php $menuAtivo = 1; // Por padrão, deixa o menu "Movimentações" expandido ?>
                    <?php foreach ($paginas as $categoria => $links) { ?>
                    <li class="bold">
                        <a class="collapsible-header waves-effect waves-light"><?= h($categoria); ?></a>
                        <div class="collapsible-body">
                            <ul>
                                <?php foreach ($links as $link) { ?>
                                    <?php if (Inflector::underscore($this->request->controller) == $link['controller'] && $this->request->action != 'dashboard') { ?>
                                        <li class="active"><a href="<?= Router::url(['controller' => $link['controller']]);  ?>"><?= h($link['nome']); ?></a></li>
                                        <?php $menuAtivo = array_search($categoria, array_keys($paginas)); ?>
                                    <?php } else { ?>
                                        <li><a href="<?= Router::url(['controller' => $link['controller']]);  ?>"><?= h($link['nome']); ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </li>
		</ul>
        <script type="text/javascript">
            // Expandir o menu ativo
            $('.side-nav ul.collapsible').collapsible('open', <?= $menuAtivo; ?>);
            $('ul.side-nav').animate({
                scrollTop: $('ul.side-nav .collapsible-body li.active').offset().top - 45
            });
            $('#expandir-menu').click(function() {
                $('body').toggleClass('hide-side-nav');
            })
        </script>
	</header>
	<main>
	    <div class="container">
			<?= $this->Flash->render() ?>
	        <?= $this->fetch('content') ?>
	    </div>
	</main>
	<footer></footer>
    <?= $this->fetch('script') ?>
</body>
</html>
