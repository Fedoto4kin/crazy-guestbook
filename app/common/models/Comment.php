<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use WebSocket\Client;

/**
 * Comment model
 *
 * @property integer $id
 * @property string $ip
 * @property string $name
 * @property string $subject
 * @property string $body
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at

 */
class Comment extends ActiveRecord
{
    private const SOCKET_PORT = '8080';
    private const SOCKET_IP = '127.0.0.1';

    public const STATUS_HIDE = 0;
    public const STATUS_SHOW = 1;

    public const EVENT_NEW_COMMENT = 'new-comment';

    private static array $_status = [
        self::STATUS_HIDE => 'Hide',
        self::STATUS_SHOW => 'Show'
   ];

    public function init()
    {
      $this->on(self::EVENT_NEW_COMMENT, [$this, 'sendToSocket']);
      parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        //TODO: Add captcha for frontend only
        return [
            [['name', 'subject', 'body', 'ip'],  'required'],
            ['name', 'match', 'pattern' => '/^[0-9\s\wА-я]/i'],
            [['body'], 'string'],
            ['status', 'in', 'range' => [self::STATUS_HIDE, self::STATUS_SHOW, null]],
            [['ip', 'subject', 'name'], 'string', 'max' => 255]
        ];
    }

    public function beforeValidate(): bool
    {
        $this->ip =  Yii::$app->request->userIP;

        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%comment}}';
    }

    public static function getStatus(int $status_id): string
    {
        if (isset(self::$_status[$status_id])) {
            return self::$_status[$status_id];
        }
        throw new \ValueError('Wrong status');
    }

    public static function statusList(): array
    {
        return self::$_status;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function sendToSocket()
    {
        //TODO: Make dependency injection for WebSocket\Client;
        $socket = sprintf("ws://%s:%s", self::SOCKET_IP, self::SOCKET_PORT);
        $msg = json_encode(
                    ['comment' => $this->getAttributes(),
                    'action' => 'push' ]
                );
        try {
            $client = new Client($socket);
            $client->send($msg);
        } catch (\Exception $e) {
            Yii::error('Cannot connect to socket');
        }
    }

}
