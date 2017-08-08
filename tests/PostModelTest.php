<?php
/**
 * Created by PhpStorm.
 * User: graychen
 * Date: 2017/8/2
 * Time: 上午11:15
 */
namespace zacksleo\yii2\post\tests;
use zacksleo\yii2\post\models\Post;

class PostModelTest extends TestCase
{
    public function testRules()
    {
        $model = new Post();
        $model->title = "测试";
        $model->img = 'i am test';
        $model->views = 1;
        $model->content = 1;
        $model->created_at = 1;
        $model->updated_at = 1;
        $model->order = 1;
        $model->status = 1;
        //$this->assertFalse($model->save(), 'property order is not set');
        //$model->order = 1;
        //$this->assertTrue($model->save(), 'add success');
    }


}