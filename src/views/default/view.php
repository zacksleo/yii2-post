<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $model common\models\Post */
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">
    <h1><?= Html::encode($this->title) ?></h1>
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
            'id',
            'title',
            'content',
            [
                'label'=>'缩略图',
                'format'=>[
                    "image",
                    [
                        "width"=>"84",
                        "height"=>"84",
                    ]
                ],
                'value'=> function($model){
                    return $_ENV['APP_HOST'].'uploads/'.$model->img;
                }
            ],
            'views',
            'order',
            'status',
            [
                'attribute'=>'created_at',
                'label'=>'修改时间',
                'value'=>
                    function($model){
                        return date('Y-m-d H:i:s',$model->updated_at);
                    }
            ],
            [
                'attribute'=>'updated_at',
                'label'=>'修改时间',
                'value'=>
                    function($model){
                        return date('Y-m-d H:i:s',$model->updated_at);
                    }
            ],
        ],
    ]) ?>
</div>