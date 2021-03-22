<!DOCTYPE HTML>
<head>
    <link type="text/css" rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <?php
		include_once(__DIR__ . "/../../src/common/header.php");
		include_once(__DIR__ . "/../../src/common/menu.php");
    ?>
    
    <!-- TODO -->

    <div class="news-container">
        <div class="news news-full">
            <div class="news-content">

                <a href="<?= "article?id=", $article['articles_id'] ?>">
                <div class="news-header"><?= $article['title'] ?></div>
                </a>
                <div class="news-header-date"> posted <?= $article['date'] ?> </div>


                <div class="news-text">
                <?= $article['content'] ?>
                </div>
                <br>
                <!-- <a class="news-read-more" href="#">Read more...</a> -->
            </div>

        </div>
    </div>
</body>