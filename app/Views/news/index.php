<h2><?= $title ?></h2>

<?php if (! empty($news) && is_array($news)) : ?>

        <?php foreach ($news as $news_item): ?>

                <h3><?= $news_item['title'] ?></h3>

                <div class="main">
                        <?= $news_item['text'] ?>
                </div>
                <p><a href="<?= '/news/'.$news_item['slug'] ?>">View article</a></p>

        <?php endforeach; ?>

<?php else : ?>

        <h3>No News</h3>

        <p>Unable to find any news for you.</p>

<?php endif ?>