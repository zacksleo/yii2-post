<?php
/**
 * Created by PhpStorm.
 * User: graychen
 * Date: 2017/8/8
 * Time: 上午11:15
 */
namespace zacksleo\yii2\post\tests;

use zacksleo\yii2\post\models\Post;
use yii\data\ActiveDataProvider;
use Yii;

class PostModelTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->model=new Post();
        $db = Yii::$app->getDb();
        $db->createCommand()->insert('post', [
            'title' => '标题',
            'img' => 'test.png',
            'views' => 1,
            'order' => 1,
            'status' => 1,
            'content' => '内容',
            'created_at' => time(),
            'updated_at' => time(),
        ])->execute();
    }

    protected function tearDown()
    {
        parent::tearDown();    
    }

    public function testRules()
    {
        $this->model->title = $this->faker->word;
        $this->assertTrue($this->model->validate(['title']));
        $this->model->title = null;
        $this->assertFalse($this->model->validate(['title']));
        $this->model->content = $this->faker->word;
        $this->assertTrue($this->model->validate(['content']));
        $this->model->content = null;
        $this->assertFalse($this->model->validate(['content']));

        $this->model->views=$this->faker->word;
        $this->assertFalse($this->model->validate(['views']));
        $this->model->views=$this->faker->randomDigitNotNull;
        $this->assertTrue($this->model->validate(['views']));

        $this->model->order=$this->faker->word;
        $this->assertFalse($this->model->validate(['order']));
        $this->model->order=$this->faker->randomDigitNotNull;
        $this->assertTrue($this->model->validate(['order']));


        $this->model->status=$this->faker->word;
        $this->assertFalse($this->model->validate(['status']));
        $this->model->status=$this->faker->randomElement($array = array($this->model::STATUS_ACTIVE,$this->model::STATUS_INACTIVE));
        $this->assertTrue($this->model->validate(['status']));

        $this->model->img = $this->faker->image($dir = '/tmp', $width = 640, $height = 480);
        $this->assertTrue($this->model->validate(['img']));
    }

    //测试资讯列表功能
    public function testFindForBackend()
    {
        $dataProvider = new ActiveDataProvider([
                'query' => Post::find(),
            ]);
        $this->assertTrue($dataProvider instanceof ActiveDataProvider);
        $hospital = $dataProvider->getModels();
        $this->assertEquals('标题', $hospital['0']['title']);
    }
    //测试单个资讯
    public function testViewForBackend()
    {
            $id=1;
            $view=$this->model->findOne($id);
            $this->assertEquals('标题', $view['title']);
    }
    //测试资讯创建功能
    public function testCreateForBackend()
    {
            $this->model->setAttributes([
                'title'=>'标题',
                'img'=>'http://www.lianluo.com/images/xpcz_img.png',
                'views'=>1496829063,
                'created_at'=>1496829063,
                'updated_at'=>'张明',
                'content'=>'2017美国CES于拉斯维加斯当地时间1月5日正式拉开帷幕，国内A股上市的科技公司联络互动（002280）携多款智能新品首次参展。',
                'status'=>1,
                'order'=>null,]);
            $this->assertTrue($this->model->save());
    }
    //测试资讯的修改功能
    public function testUpdateForBackend()
    {
            $this->model->setAttributes([
                'id'=>2,
                'title'=>'标题',
                'img'=>'http://www.lianluo.com/images/xpcz_img.png',
                'views'=>1496829063,
                'created_at'=>1496829063,
                'updated_at'=>'张明',
                'content'=>'2017美国CES于拉斯维加斯当地时间1月5日正式拉开帷幕，国内A股上市的科技公司联络互动（002280）携多款智能新品首次参展。',
                'status'=>1,
                'order'=>null
            ]);
            $this->assertTrue($this->model->save());
    }
    //测试资讯的删除功能
  //  public function testDeleteForBackend()
  //  {
  //          $id=$this->model->setAttributes([
  //              'title'=>'标题',
  //              'img'=>'http://www.lianluo.com/images/xpcz_img.png',
  //              'views'=>1496829063,
  //              'created_at'=>1496829063,
  //              'updated_at'=>'张明',
  //              'content'=>'2017美国CES于拉斯维加斯当地时间1月5日正式拉开帷幕，国内A股上市的科技公司联络互动（002280）携多款智能新品首次参展。',
  //              'status'=>1,
  //              'order'=>null
  //          ]);
  //          $this->assertEquals('1', $this->model->findOne(2)->delete());
  //  }
}
