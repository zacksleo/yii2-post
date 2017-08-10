<?php
namespace zacksleo\yii2\post\tests;

use Yii;
use yii\helpers\ArrayHelper;
use Faker\Factory;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $model;
    protected $faker;

    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
        $this->createTestDbData();
        $this->faker=Factory::create('zh_CN');
    }
    protected function tearDown()
    {
        $this->destroyTestDbData();
        $this->destroyApplication();
        unset($this->model);
    }

    /**
     * Populates Yii::$app with a new application
     * The application will be destroyed on tearDown() automatically.
     *
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        return new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost:3306;dbname=test',
                    'username'=> 'root',
                    'password'=> '',
                    'tablePrefix' => 'tb_'
                ],
                'i18n' => [
                    'translations' => [
                        '*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                        ]
                    ]
                ],
            ],
            'modules' => [
                'post' => [
                    'class' => 'zacksleo\yii2\post\Module',
                    'layout' => '@tests/layouts/main'
                ]
            ]
        ], $config));
    }
    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost:3306;dbname=test',
                    'username'=> 'root',
                    'password'=> '',
                    'tablePrefix' => 'tb_'
                ],
                'i18n' => [
                    'translations' => [
                        '*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                        ]
                    ]
                ],
            ],
            'modules' => [
                'post' => [
                    'class' => 'zacksleo\yii2\post\Module'
                ]
            ]
        ], $config));
    }
    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }
    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        if (\Yii::$app && \Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }
    protected function destroyTestDbData()
    {
        $db = Yii::$app->getDb();
        $res = $db->createCommand()->dropTable('tb_post')->execute();
    }
    protected function createTestDbData()
    {
        $db = Yii::$app->getDb();
        try {
            $db->createCommand()->createTable('tb_post', [
                'id' => 'pk',
                'title' =>'string(255) not null' ,
                'img' => 'string(255)' ,
                'views' => 'integer(11) not null',
                'order' => 'integer(11)',
                'status' => 'tinyint(1)',
                'content' => 'text',
                'created_at' => 'integer(11) not null',
                'updated_at' => 'integer(11) not null'
             ])->execute();
        } catch (Exception $e) {
            return;
        }
    }
}
