<?php

/* @var $comments common\models\Comment */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Comments';

?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table-bordered table" id="comments-table">
        <tr>
            <th>#ID</th>
            <th>STATUS</th>
            <th>IP ADDRESS</th>
            <th>COMMENT</th>
            <th colspan="2">ACTIONS</th>
        </tr>
        <? foreach ($comments as $comment ): ?>
              <?= $this->render('comment/_commentrow', [
                'comment' => $comment,
                ]) ?>
        <? endforeach; ?>
    </table>
</div>
<script type="application/javascript">

    $(document).ready(function() {

        var conn = new WebSocket('ws://127.0.0.1:8080');
        conn.onmessage = function(e) {
            json_data = JSON.parse(e.data);
            $.get('<?= Url::to(['site/view']); ?>',  { id: json_data.id }).done(
                function(data) {
                    $('#comments-table tr:first').after(data);
                }
            );
        };
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
    });


</script>
