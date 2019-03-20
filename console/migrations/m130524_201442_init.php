<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('customers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp(),
        ]);

        $this->createTable('vehicles', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'state' => $this->string(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp(),
        ]);

        $this->createTable('customer_vehicles', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            'vehicle_id' => $this->integer()->notNull(),
            'primary_relation' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp(),
        ]);
    }

    public function down()
    {
        $this->dropTable('customer_vehicles');
        $this->dropTable('vehicles');
        $this->dropTable('customers');
    }
}
