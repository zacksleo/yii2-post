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
                    'password'=> '206065'
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
                    'password'=> '206065'
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
    }
    protected function createTestDbData()
    {

        $this->mockApplication()->runAction('/migrate',['migrationPath'=>'@zacksleo/yii2/post/migrations']);
    }
}
