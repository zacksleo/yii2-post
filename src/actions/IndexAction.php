<?php

namespace zacksleo\yii2\post\actions;

use yii\data\ActiveDataProvider;
use yii\base\Action;
use zacksleo\yii2\post\models\Post;

class IndexAction extends Action
{
    public function run()
    {
        return new ActiveDataProvider(
            [
                'query' => Post::find()->where(
                    [
                        'status' => POST::STATUS_ACTIVE
                    ]
                )->orderBy('order DESC')
            ]
        );
    }
}
