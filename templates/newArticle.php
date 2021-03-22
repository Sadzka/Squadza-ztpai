<!DOCTYPE HTML>
<?php
    $permissions = false;
    if( $this->currentUser != null) {
        if ($this->currentUser->haveModPerms()) {
            $permissions = true;
        }
    }
    if (!$permissions) {
        $url = "http://$_SERVER[HTTP_HOST]";
        echo 'xxx';
        header("Location: {$url}/index");
        echo 'yyy';
        return;
    }
?>

<head>
    <link type="text/css" rel="stylesheet" href="public/css/main.css">
	<script type="text/javascript" src="./public/js/article.js" defer></script>
</head>

<body>
    <?php
		include_once(__DIR__ . "/../../src/common/header.php");
		include_once(__DIR__ . "/../../src/common/menu.php");
    ?>
    <div class="article-edit-body">
    
        <form action="#" method="POST" ENCTYPE="multipart/form-data">
            <h2>New Article</h2>
            <textarea rows="1" class="comment-editbox" name="title" maxlength="128" placeholder="title"></textarea>
            <textarea rows="20" class="comment-editbox" name="body" maxlength="65535" placeholder="content"></textarea>
            <div class="char-remains">Up to 65535 characters. 65535 characters remaining.</div>
            
            <h3>Article Image:</h3> <input type="file" name="file"><br>

            <div class="messages">
            <?php
                if(isset($messages)) {
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
            ?>
            </div>

            <input type="submit" value="Submit" class="button comment-button">
            <!--<button type="submit">UPLOAD</button>-->
        
        </form>

    </div>
    
</body>