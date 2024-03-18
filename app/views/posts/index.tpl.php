<?php require VIEWS . '/incs/header.php' ?>

<main class="main py-3">

    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <?= $pagination ?>

                <?php foreach ($posts as $post): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><a href="posts/<?= $post['slug'] ?>"><?= h($post['title']) ?></a></h5>
                                <p class="card-text"><?= $post['excerpt'] ?></p>
                                <a href="posts/<?= $post['slug'] ?>">Go somewhere</a>
                            </div>
                        </div>
                <?php endforeach; ?>

                <hr>

                <?= $pagination ?>

            </div>

            <?php require VIEWS . '/incs/sidebar.php' ?>
        </div>
    </div>

</main>

<?php require VIEWS . '/incs/footer.php' ?>