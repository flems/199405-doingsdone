<main class="content">
    <div class="content__main-col">
        <header class="content__header">
            <h2 class="content__header-text">Ошибка</h2>
        </header>
        <article class="gif-list">
            <?php foreach ($error as $key => $value): ?>
                <p class="error"><?=$key?>: <?=$value;?></p>
            <?php endforeach; ?>
        </article>
    </div>
</main>
