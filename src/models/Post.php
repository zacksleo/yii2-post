<?php

namespace zacksleo\yii2\post\models;

use common\helpers\files\File;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use zacksleo\yii2\post\Module;
use zacksleo\yii2\post\behaviors\UploadBehavior;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $img
 * @property integer $views
 * @property string $content
 * @property string $create
 * @property string $updated_at
 */
class Post extends \yii\db\ActiveRecord
{
    public $imgFile;

    const STATUS_ACTIVE = 1; //上线
    const STATUS_INACTIVE = 0; //下线

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['views', 'order', 'status'], 'integer'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['img'], 'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg, gif, jpeg, bmp, svg, webp',
                'maxFiles' => 1,
                'maxSize' => 300000,
                'on' => ['insert', 'update']
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Module::t('post', 'title'),
            'img' => Module::t('post', 'img'),
            'views' => Module::t('post', 'views'),
            'content' => Module::t('post', 'content'),
            'created_at' => Module::t('post', 'created at'),
            'updated_at' => Module::t('post', 'updated at'),
            'order' => Module::t('post', 'order'),
            'status' => Module::t('post', 'status'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className()
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'img',
                'scenarios' => ['insert', 'update'],
                'path' => '@frontend/web/uploads/galleries/posts',
                'url' => '@web/uploads/galleries/posts',
            ],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['img'] = function ($fields) {
            $path = str_replace('api/uploads/', '', $this->getUploadUrl('img'));
            if (isset($_ENV['API_HOST'])) {
                $url = $_ENV['API_HOST'] . 'files/' . $path;
            } else {
                $url = Url::to(['file/view', 'path' => $path], true);
            }
            return $url;
        };
        $fields['url'] = function ($fields) {
            $url = $_ENV['APP_HOST'] . 'post/view' . "?id=" . $fields['id'];
            return $url;
        };
        unset($fields['id'], $fields['created_at'], $fields['updated_at'], $fields['content'], $fields['order'], $fields['status']);
        return $fields;
    }

    public function getUrl()
    {
        return $_ENV['APP_HOST'] . '/post/view?id=' . $this->id;
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_INACTIVE => Module::t('post', 'offline'),
            self::STATUS_ACTIVE => Module::t('post', 'online'),
        ];
    }

    public function getImgUrl()
    {
        return $_ENV['APP_HOST'] . 'uploads/galleries/posts/' . $this->img;
    }
}
