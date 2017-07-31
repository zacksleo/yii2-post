<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use zacksleo\yii2\post\Module;
use zacksleo\yii2\post\models\Post;

/* @var $this yii\web\View */
/* @var $model zacksleo\yii2\post\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="post-form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'img')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'apk/*',
            'multiple' => false
        ],
        'pluginOptions' => [
            'initialPreview' => [
                $model->img,
            ],
            'showRemove' => true,
            'showPreview' => false,
            'initialPreviewAsData' => false,
            'initialCaption' => $model->img,
            'overwriteInitial' => false,
        ]
    ])->hint('在此上传文件'); ?>
    <?= $form->field($model, 'views')->textInput() ?>
    <?= $form->field($model, 'order')->textInput() ?>
    <?= $form->field($model, 'status')->radioList(Post::getStatusList()) ?>
    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor', []) ?>
    <div class="form-group">
        <?= Html::submitButton(Module::t('post', $model->isNewRecord ? 'Create' : 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>