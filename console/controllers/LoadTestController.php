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

        $vehicles = Customer::findOne( ['name'=>'Customer1'] )
            ->getVehicles()
            ->andWhere( ['active'=>true] )
            ->all();

        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Vehicles found: ' . $this->ansiFormat( count($vehicles), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }

    public function actionUseJoin()
    {
        $start = microtime( true );

        $vehicles = Customer::findOne( ['name'=>'Customer1'] )
            ->getVehiclesViaJoin()
            ->andWhere( ['active'=>true] )
            ->all();

        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Vehicles found: ' . $this->ansiFormat( count($vehicles), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }

    public function actionUseViaTable()
    {
        $start = microtime( true );

        $vehicles = Customer::findOne( ['name'=>'Customer1'] )
            ->getVehiclesViaTable()
            ->andWhere( ['active'=>true] )
            ->all();

        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Vehicles found: ' . $this->ansiFormat( count($vehicles), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }

    public function actionWith()
    {
        $start = microtime( true );

        $customers = Customer::find()
            ->with(['vehicles' => function($q){
                $q->andWhere(['active' => true]);
            }])
            ->all();

        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Customers found: ' . $this->ansiFormat( count($customers), Console::FG_GREEN) );
        $this->stdout("\n");
        foreach($customers as $customer) {
            $this->stdout( 'Customer Name: ' . $this->ansiFormat( $customer->name, Console::FG_GREEN) );
            $this->stdout(", ");
            $this->stdout( 'Active Vehicles: ' . $this->ansiFormat( count($customer->vehicles), Console::FG_GREEN) );
            $this->stdout("\n");
        }
        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }

    public function actionWithDirect()
    {
        $start = microtime( true );

        $customers = Customer::find()
            ->with(['vehiclesViaTable' => function($q){
                $q->andWhere(['active' => true]);
            }])
            ->all();

        $totalTime = microtime( true ) - $start;

        $this->stdout( 'Customers found: ' . $this->ansiFormat( count($customers), Console::FG_GREEN) );
        $this->stdout("\n");
        foreach($customers as $customer) {
            $this->stdout( 'Customer Name: ' . $this->ansiFormat( $customer->name, Console::FG_GREEN) );
            $this->stdout(", ");
            $this->stdout( 'Active Vehicles: ' . $this->ansiFormat( count($customer->vehiclesViaTable), Console::FG_GREEN) );
            $this->stdout("\n");
        }
        $this->stdout( 'Memory Usage in bytes: ' . $this->ansiFormat( memory_get_usage(), Console::FG_GREEN) );
        $this->stdout("\n");
        $this->stdout( 'Total execution time: ' . $this->ansiFormat($totalTime, Console::FG_GREEN) );
        $this->stdout("\n");
    }
}
