<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about content-container">
    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <h4>Test for Full-Stack developer:</h4>

    <p>You need to create a simple commenting system (front-end and administration area) with the Yii framework:</p>
    <p><strong>Front-end:</strong> A person fills in a comment filed (makes a post) without logging in.
        The post appears in the comments feed.</p>
    <p><strong>Administration area:</strong>
        the administrator logs in and sees the list of comments (content, date, etc.),
        can edit the comment / delete it.
        When a new comment was posted in front-end - administrator sees it in administrative area's
        list of comments updated in realtime (web-sockets are used for this),
        also notification about new comment pops out.</p>

</div>
