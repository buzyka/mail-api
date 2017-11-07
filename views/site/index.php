<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$exampleUrl = Url::to('@web/message/list', true);

$this->title = 'Mailbox API';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully installed Mailbox API.</p>
        <p class="lead">Your endpoint <a href="<?=$exampleUrl?>"><?=$exampleUrl?></p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>
</div>
