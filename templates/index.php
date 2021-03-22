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

    <?php
    if($this->currentUser != null
    && $this->currentUser->haveModPerms()) : ?>

        <div class="inline-flex">
			<h2 class="">Articles</h2>
			<a href="newArticle">
				<div class="add-comment">
				New Article
				</div>
			</a>
		</div>
        
    <?php endif; ?>

    <?php foreach($articles as $article): ?>
    
        <div class="news">
        
            <img class="news-icon" src="<?= "public/uploads/articles-icons/" . $article['image'] ?>">
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
    <?php endforeach; ?>
    </div>
</body>