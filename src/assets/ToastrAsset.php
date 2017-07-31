<?php

namespace zacksleo\yii2\post\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@npm/toastr';
    public $publishOptions = [
        'only' => [
            'build/*',
        ]
    ];
    public $css = [
        'build/toastr.min.css'
    ];
    public $js = [
        'build/toastr.min.js'
    ];
    public $jsOptions = [
        'position' => View::POS_END
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
