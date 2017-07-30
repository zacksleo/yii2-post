<?php
use yii\helpers\Html;
use yii\grid\GridView;
use zacksleo\yii2\post\assets\ClipboardAsset;
use zacksleo\yii2\post\Module;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Module::t('post', 'Posts');
$this->params['breadcrumbs'][] = Module::t('post', 'Posts');
ClipboardAsset::register($this);
?>
<style type="text/css">
    .color-blue {
        color: #337ab7;
    }
</style>
<div class="post-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Module::t('post', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
                    return $_ENV['APP_HOST'] . 'uploads/' . $model->img;
                }
            ],
            'title',
            'order',
            'updated_at:date',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {up} {url}',
                'buttons' => [
                    'up' => function ($url, $model, $key) {
                        if ($model->status == 1) {
                            $span = Html::tag('a id="status_' . $model->id . '" class="glyphicon glyphicon-ok color-blue"  title="状态" aria-label="状态" onclick="setStatus(' . $model->id . ',0)"></a');
                            return Html::a($span, '#');
                        } else {
                            $span = Html::tag('a id="status_' . $model->id . '" class="glyphicon glyphicon-remove color-blue" title="状态" aria-label="状态" onclick="setStatus(' . $model->id . ',1)"></a');
                            return Html::a($span, '#');
                        }
                    },
                    'url' => function ($url, $model, $key) {
                        $span = Html::tag('a class="glyphicon glyphicon-link color-blue" title="拷贝链接" aria-label="拷贝链接" onclick="copyUrl(\'' . $model->url . '\')"></a');
                        return Html::a($span, '#');
                    }
                ]
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    /**
     * @brief 修改文章的状态是否显示
     *
     * @param id
     * @param status 是否显示（1:显示0:不显示）
     *
     * @return
     */
    function setStatus(id, status) {
        $.ajax({
            type: "GET",
            url: "status",
            data: {id: id, status: status},
            success: function (rep) {
                if (rep.status === 1) {
                    if (status === 1) {
                        $("#status_" + id).removeClass("glyphicon-remove").addClass("glyphicon-ok");
                        $("#status_" + id).attr("onclick", "setStatus(" + id + ",0)");
                    } else {
                        $("#status_" + id).removeClass("glyphicon-ok").addClass("glyphicon-remove");
                        $("#status_" + id).attr("onclick", "setStatus(" + id + ",1)");
                    }
                } else {
                    alert("修改失败");
                }
            },
            error: function (rep) {
                alert("网络错误");
            }
        });
    }
    function copyUrl(url) {
        clipboard.copy(url).then(
            function () {
                alert("复制成功");
            },
            function (err) {
                alert("复制失败");
            }
        );
    }
</script>
