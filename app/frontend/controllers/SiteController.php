<?php
namespace frontend\controllers;

use common\models\Comment;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $comments = Comment::find()
            ->where(['status' => Comment::STATUS_SHOW])
            ->orderBy(new Expression('RANDOM()')) // MYSQL case must be RAND() function
            ->all();

        return $this->render('index', ['comments' => $comments]);
    }

    /**
     * Displays add comment page.
     *
     * @return mixed
     */
    public function actionComment()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $model->trigger(Comment::EVENT_NEW_COMMENT);
                Yii::$app->session->setFlash('success', 'Thank you for post your comment. We will publish it after moderating you as soon as possible.');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Cannot save into DB. Please, try later.');
                return $this->refresh();
            }
        } else {
            return $this->render('comment', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
