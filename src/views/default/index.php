<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use zacksleo\yii2\post\assets\ClipboardAsset;
use zacksleo\yii2\post\assets\ToastrAsset;
use zacksleo\yii2\post\Module;
use zacksleo\yii2\post\models\Post;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Module::t('post', 'Posts');
$this->params['breadcrumbs'][] = Module::t('post', 'Posts');
ClipboardAsset::register($this);
ToastrAsset::register($this);
?>
<style type="text/css">
    .color-blue {
        color: #337ab7;
    }
</style>
<div class="post-index">
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
                    return $model->getImgUrl();
                }
            ],
            'title',
            'order',
            'updated_at:date',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {up} {url}',
                'buttons' => [
                    'up' => function ($url, $model, $key) {
                        if ($model->status == Post::STATUS_ACTIVE) {
                            $span = Html::tag('a id="status_' . $model->id . '" class="glyphicon glyphicon-remove color-blue"  title="' . Module::t('post', 'offline') . '" onclick="setStatus(' . $model->id . ',0)"></a');
                            return Html::a($span, '#');
                        } else {
                            $span = Html::tag('a id="status_' . $model->id . '" class="glyphicon glyphicon-ok color-blue" title="' . Module::t('post', 'online') . '" onclick="setStatus(' . $model->id . ',1)"></a');
                            return Html::a($span, '#');
                        }
                    },
                    'url' => function ($url, $model, $key) {
                        $span = Html::tag('a class="glyphicon glyphicon-link color-blue cp" title="复制链接" data-clipboard-text="' . $model->url . '"></a');
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
     * @param id
     * @param status 是否显示（1:显示0:不显示）
     * @return
     */
    function setStatus(id, status) {
        $.ajax({
            type: "GET",
            url: "<?= Url::to(['status'])?>",
            data: {id: id, status: status},
            success: function (rep) {
                if (rep.status === 1) {
                    if (status === 1) {
                        $("#status_" + id).removeClass("glyphicon-ok").addClass("glyphicon-remove");
                        $("#status_" + id).attr("onclick", "setStatus(" + id + ",0)");
                    } else {
                        $("#status_" + id).removeClass("glyphicon-remove").addClass("glyphicon-ok");
                        $("#status_" + id).attr("onclick", "setStatus(" + id + ",1)");
                    }
                    toastr.success('设置成功');
                } else {
                    toastr.error('修改失败');
                }
            },
            error: function (rep) {
                toastr.error('网络错误');
            }
        });
    }
</script>
<?php
$js = <<<JS
var clipboard = new Clipboard('.cp');
toastr.options = {
  "closeButton": true,
  "debug": false,
  "positionClass": "toast-top-right",
  "onclick": null,
  "showDuration": "1000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
clipboard.on('success', function(e) {
    toastr.success('复制成功');    
    e.clearSelection();
});

clipboard.on('error', function(e) {    
    toastr.error('复制失败');
});
JS;
$this->registerJs($js, View::POS_END);
?>
