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
    private const SOCKET_ADDR = '127.0.0.1';

    public const STATUS_HIDE = 0;
    public const STATUS_SHOW = 1;


    private static $_status = [
        self::STATUS_HIDE => 'Hide',
        self::STATUS_SHOW => 'Show'
   ];


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
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

    public function sendToSocket() {

        //TODO: Catch no connection
        $socket = sprintf("ws://%s:%s", self::SOCKET_ADDR, self::SOCKET_PORT);
        $client = new Client($socket);
        $client->send(json_encode($this->getAttributes()));

    }

}
