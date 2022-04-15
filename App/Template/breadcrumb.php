<?php 
    if(!$this->isHome())
        { ?>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="custom-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/chat/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $this->prepareBreadCrumb() ?></li>
        </ol>
        </nav>
    <?php }
?>

