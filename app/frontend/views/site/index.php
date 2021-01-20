<?php

/* @var $comments common\models\Comment */

use Yii;

/* @var $this yii\web\View */

$this->title = 'My Guestbook';
$formatter = Yii::$app->formatter;

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
        <?php foreach ($comments as $comment): ?>
            <div class="col-lg-4 card">
                <div class="card-body clearfix">
                   <figure>
                      <h4><?=$comment->subject ?></h4>
                    <blockquote >
                         <p><?=$comment->body ?></p>
                    </blockquote>
                    <span class="pull-right text-muted text-right"><?=$comment->name ?><br><?= $formatter->asDate($comment->created_at, 'long') ?></span>
                </figure>
                </div>
            </div>
        <?php endforeach; ?>
        </div>

    </div>
</div>
