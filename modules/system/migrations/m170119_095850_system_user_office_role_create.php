<?php

use yii\db\Migration;

class m170119_095850_system_user_office_role_create extends Migration
{
    public function getSchema()
    {
        return 'system';
    }

    public function safeUp()
    {
        $this->execute('CREATE SCHEMA ' . $this->getSchema() . ';');

        //create and fill system.office
        $this->execute('
        CREATE TABLE ' . $this->getSchema() . '.office (
            id SERIAL NOT NULL,
            code VARCHAR(2),
            name VARCHAR(20),
            PRIMARY KEY(id)
        );
        ');

        $this->insert($this->getSchema() . '.office', ['id' => 1, 'code' => 'ru', 'name' => 'Россия']);
        $this->insert($this->getSchema() . '.office', ['id' => 2, 'code' => 'en', 'name' => 'Europe']);
        $this->execute('SELECT setval(\'' . $this->getSchema() . '.office_id_seq\', 2)');

        //create and fill system.role
        $this->execute('
        CREATE TABLE ' . $this->getSchema() . '.role (
            id SERIAL NOT NULL,
            role_ru VARCHAR(20),
            role_eu VARCHAR(20),
            PRIMARY KEY(id)
        );
        ');

        $this->insert($this->getSchema() . '.role', ['id' => 1, 'role_ru' => 'Администратор', 'role_eu' => 'Admin']);
        $this->insert($this->getSchema() . '.role', ['id' => 2, 'role_ru' => 'Поддержка', 'role_eu' => 'Support']);

        $this->execute('SELECT setval(\'' . $this->getSchema() . '.role_id_seq\', 6)');

        //create system.user
        $this->execute('
        CREATE TABLE ' . $this->getSchema() . '.user (
            id SERIAL NOT NULL,
            username VARCHAR(20),
            email VARCHAR(20),
            first_name VARCHAR(40),
            middle_name VARCHAR(40),
            second_name VARCHAR(40),
            phone VARCHAR(15),
            password_hash VARCHAR(60),
            auth_key VARCHAR(32),
            chat_agent_id VARCHAR(20),
            office_id INT,
            role_id INT,
            PRIMARY KEY(id)
        )
        ');

        $this->addForeignKey('sysuser_office_id', $this->getSchema() . '.user', 'office_id', $this->getSchema() . '.office', 'id');
        $this->addForeignKey('sysuser_role_id', $this->getSchema() . '.user', 'role_id', $this->getSchema() . '.role', 'id');

        $this->insert(
            $this->getSchema() . '.user',
            [
                'id' => 1,
                'username' => 'sysuser',
                'email' => 'fake@email.ru',
                'first_name' => 'Админ',
                'password_hash' => \Yii::$app->security->generatePasswordHash('password'),
                'auth_key' => Yii::$app->security->generateRandomString(),
                'role_id' => 1,
                'office_id' => 1,
            ]
        );
        $this->execute('SELECT setval(\'' . $this->getSchema() . '.user_id_seq\', 1)');

        return true;
    }

    public function safeDown()
    {
        $this->execute('DROP TABLE ' . $this->getSchema() . '.user;');
        $this->execute('DROP TABLE ' . $this->getSchema() . '.role;');
        $this->execute('DROP TABLE ' . $this->getSchema() . '.office;');
        $this->execute('DROP SCHEMA ' . $this->getSchema() . ';');

        return true;
    }

}
