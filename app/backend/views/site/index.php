<?php

/* @var $comments common\models\Comment */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;

$this->title = 'Comments';
$path = $this->assetManager->getBundle(AppAsset::class)->baseUrl;

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
        <?php foreach ($comments as $comment): ?>
              <?= $this->render('comment/_commentrow', [
                'comment' => $comment,
                ]) ?>
        <?php endforeach; ?>
    </table>

</div>

<?
#TODO: Create Asset bundle
?>
<script type="application/javascript">
    function play_sound() {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '<?= $path ?>/sounds/notification-alert.wav');
        audioElement.setAttribute('autoplay', 'autoplay');
    }

    $(document).ready(function() {
        var conn = new WebSocket('ws://127.0.0.1:8080');
        conn.onmessage = function(e) {
            json_data = JSON.parse(e.data);
            $.get('<?= Url::to(['site/view']); ?>',  { id: json_data.id }).done(
                function(data) {
                    $('#comments-table tr:first').after(data);
                     play_sound();
                }
            );
        };
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        conn.onclose = function(e) {
            alert('Web socket close connection!');
        };

    });


</script>
