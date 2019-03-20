<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property int $id
 * @property string $name
 * @property string $state
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Vehicle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicles';
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomerVehicles()
    {
        return $this->hasMany(CustomerVehicle::class, ['vehicle_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customer::class, ['id' => 'customer_id'])
            ->via('customerVehicles');
    }
}
