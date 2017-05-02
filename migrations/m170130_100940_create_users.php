<?php

use yii\db\Migration;

class m170130_100940_create_users extends Migration
{
    public function getSchema()
    {
        return 'public';
    }

    public function safeUp()
    {
        $this->execute('
        CREATE TABLE ' . $this->getSchema() . '.user (
            id SERIAL NOT NULL,
            is_active BOOLEAN,
            username VARCHAR(20),
            email VARCHAR(20),
            first_name VARCHAR(40),
            middle_name VARCHAR(40),
            second_name VARCHAR(40),
            day_of_birth DATE,
            is_male BOOLEAN,
            phone VARCHAR(15),
            country VARCHAR(40),
            region VARCHAR(40),
            city VARCHAR(40),
            address VARCHAR(100),
            post_index CHAR(6),            
            comment TEXT,
            password_hash VARCHAR(60),
            auth_key VARCHAR(32),
            created_at TIMESTAMP, 
            created_by INTEGER,
            updated_at TIMESTAMP,
            updated_by INTEGER,
            office_id INTEGER,
            PRIMARY KEY(ID)
        );
        ');

        $this->addForeignKey('user_office_id', $this->getSchema() . '.user', 'office_id', 'system.office', 'id');
        $this->addForeignKey('user_creator_id', $this->getSchema() . '.user', 'created_by', 'system.user', 'id');
        $this->addForeignKey('user_updater_id', $this->getSchema() . '.user', 'updated_by', 'system.user', 'id');
    }

    public function safeDown()
    {
        $this->execute('DROP TABLE ' . $this->getSchema() . '.user');
    }
}
