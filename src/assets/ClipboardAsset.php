<?php

namespace zacksleo\yii2\post\assets;

use yii\web\AssetBundle;

class ClipboardAsset extends AssetBundle
{
    public $sourcePath = '@npm/clipboard-js';

    public $js = [
        "clipboard.min.js"
    ];
}
