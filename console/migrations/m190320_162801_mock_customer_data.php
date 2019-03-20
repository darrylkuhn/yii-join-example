<?php

use yii\db\Migration;
use yii\db\Expression;
use app\models\Customer;
use app\models\Vehicle;
use app\models\CustomerVehicle;

/**
 * Class m190320_162801_mock_customer_data
 */
class m190320_162801_mock_customer_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $createCustomers = 10;
        $createVehicles = 5000;
        $assignToCustomer1 = 2500;

        $customerCount = 0;
        while ( $customerCount < $createCustomers )
        {
            $c = new Customer;
            $c->name = "Customer{$customerCount}";
            $c->save();
            $customerCount++;
        }

        $vehicleCount = 0;
        while ( $vehicleCount < $createVehicles )
        {
            $v = new Vehicle;
            $v->name = "Vehicle{$vehicleCount}";
            $v->state = '{"latitude":{"value":32.699402,"ts":"2016-05-30 01:00:46"},"longitude":{"value":-76.57714,"ts":"2016-05-30 01:00:46"},"zone1":{"value":12.66,"ts":"2016-05-30 01:00:46"},"zone2":{"value":7,"ts":"2016-05-30 01:00:46"}}';

            // Activate just a few vehicles
            $v->active = $vehicleCount < 5 ? true : false;

            $v->save();
            $vehicleCount++;
        }

        $customer1 = Customer::findOne([ 'name'=>'Customer1'] );

        $vehicles = Vehicle::find()
            ->limit($assignToCustomer1);

        foreach( $vehicles->each() as $vehicle )
        {
            $vehicle->link( 'customers', $customer1 );
        }

        $unlinkedVehicleCount = $createVehicles - $assignToCustomer1;

        while ( $unlinkedVehicleCount < $createVehicles )
        {
            $linkedVehicles = Vehicle::find()
                ->select( Vehicle::tableName() . '.id' )
                ->innerJoin( CustomerVehicle::tableName(), Vehicle::tableName() . '.id = ' . CustomerVehicle::tableName() . '.vehicle_id' )
                ->asArray()
                ->all();

            $customer = Customer::find()
                ->orderBy(new Expression('rand()'))
                ->one();

            $danglingVehicles = Vehicle::find()
                ->andWhere( ['NOT', ['id' => $linkedVehicles]] )
                ->limit(300);

            foreach( $danglingVehicles->each() as $vehicle )
            {
                $vehicle->link( 'customers', $customer );
            }

            $unlinkedVehicleCount = Vehicle::find()
                ->innerJoin( CustomerVehicle::tableName(), Vehicle::tableName() . '.id = ' . CustomerVehicle::tableName() . '.vehicle_id' )
                ->count();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        CustomerVehicle::deleteAll();
        Vehicle::deleteAll();
        Customer::deleteAll();

        return true;
    }
}
