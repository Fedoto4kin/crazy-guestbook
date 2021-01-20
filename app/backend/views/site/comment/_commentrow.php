<?php
/* @var $comment common\models\Comment */

use common\models\Comment;
use yii\helpers\Url;

?>
<tr>
    <td><?= $comment->id ?></td>
    <td><?= Comment::getStatus($comment->status) ?></td>
    <td><?= $comment->ip ?></td>
    <td><h4><?= $comment->subject ?></h4>
        <?= $comment->body ?>
        <hr>
        <?= $comment->name ?>: <?= $comment->created_at ?>
    </td>
    <td>
        <a class="btn btn-info" href="<?= Url::to(['site/update', 'id' => $comment->id]); ?>">EDIT</a>
    </td>
    <td>
        <a class="btn btn-warning" href="<?= Url::to(['site/delete', 'id' => $comment->id]); ?>">DELETE</a>
    </td>
</tr>