<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use zacksleo\yii2\post\models\Post;
use zacksleo\yii2\post\Module;

/* @var $this yii\web\View */
/* @var $model \zacksleo\yii2\post\models\Post */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'content:raw',
            [
                'label' => '缩略图',
                'format' => [
                    "image",
                    [
                        "width" => "84",
                        "height" => "84",
                    ]
                ],
                'value' => function ($model) {
                    return $model->getImgUrl();
                }
            ],
            'views',
            'order',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Post::getStatusList()[$model->status];
                }
            ],
            'created_at:date',
            'updated_at:date'
        ],
    ]) ?>
</div>