<?php
namespace console\controllers;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use app\models\Customer;

class LoadTestController extends Controller
{
    public function actionUseVia()
    {
        $start = microtime( true );
        $vehicle = Customer::findOne( ['name'=>'Customer1'] )->getVehicles()->one();
        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }

    public function actionUseJoin()
    {
        $start = microtime( true );
        $vehicle = Customer::findOne( ['name'=>'Customer1'] )->getVehiclesViaJoin()->one();
        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }
}
