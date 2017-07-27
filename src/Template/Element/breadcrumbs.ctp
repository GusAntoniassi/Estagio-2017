<div class="row breadcrumbs-wrapper">
    <div class="col s12">
        <?php foreach ($crumbs as $nome => $link) { ?>
            <a href="<?= $link; ?>" class="breadcrumb"><?= h($nome); ?></a>
        <?php } ?>
    </div>
</div>