<?php

namespace zacksleo\yii2\post\models;

use common\helpers\files\File;
use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use zacksleo\yii2\post\Module;

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
            [['imgFile'], 'file',
                'skipOnEmpty' => true,
                'tooBig' => '文件大小不超过1M',
                'maxFiles' => 1,
                'maxSize' => 10000000
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
            'imgFile' => Module::t('post', 'File'),
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
            ]
        ];
    }

    public function beforeValidate()
    {
        if (isset($_POST['Post']['imgFile'])) {
            $file = UploadedFile::getInstance($this, 'imgFile');
            if (!empty($file)) {
                $this->imgFile = $file;
            }
        }
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->imgFile instanceof UploadedFile) {
            if ($path = (new File($this->imgFile))->upload()) {
                $this->img = $path;
            } else {
                $this->addError('imgFile', $this->imgFile->getHasError());
                return false;
            }
        } else {
            $this->img = $this->getOldAttribute('img');
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        $this->img = $this->getOldAttribute('img');
        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        File::delete($this->img);
        parent::afterDelete();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (!$insert) {
            if (!empty($changedAttributes['img'])) {
                File::delete($changedAttributes['img']);
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['img'] = function ($fields) {
            $url = $_ENV['APP_HOST'] . 'uploads/' . $fields['img'];
            return $url;
        };
        $fields['url'] = function ($fields) {
            $url = $_ENV['APP_HOST'] . 'post/view' . "?id=" . $fields['id'];
            return $url;
        };
        unset($fields['id'], $fields['created_at'], $fields['updated_at']);
        $request = Yii::$app->request;
        if ($request->isGet) {
            unset($fields['content'], $fields['order'], $fields['status']);
        }
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
}
