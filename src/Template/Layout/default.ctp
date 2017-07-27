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
				<div class="brand-logo"><?= $this->fetch('title'); ?></div>
				<ul id="nav-links" class="right">
					<li><a href="#">Links</a></li>
					<li><a href="#">Uteis</a></li>
					<li><a href="#">Depois</a></li>
					<li><a href="#">Vejo</a></li>
				</ul>
			</div>
		</nav>
		<ul class="side-nav fixed hide-on-med-and-down">
			<li><a href="#!">Link</a></li>
			<li><a href="#!">Link</a></li>
			<li><a href="#!">Link</a></li>
		</ul>
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
