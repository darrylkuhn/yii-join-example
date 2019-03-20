<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * @return ActiveQuery
     */
    public function getCustomerVehicles()
    {
        return $this->hasMany(CustomerVehicle::class, ['customer_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicle::class, ['id' => 'vehicle_id'])
            ->via('customerVehicles');
    }

     /**
     * @return ActiveQuery
     */
    public function getVehiclesViaJoin()
    {
        $query = Vehicle::find();
        $query->multiple = true;
        $query->innerJoin(
            CustomerVehicle::tableName() . ' cv',
            // by specifying customer_id in join-on clause, primary key index on that table can be used
            'cv.customer_id = :cid AND cv.vehicle_id = vehicles.id',
            [':cid' => $this->id]
        );

        return $query;
    }
}
