<?php

namespace Migration;

use Phoenix\Migration\AbstractMigration;

class CreateCustomersTable extends AbstractMigration
{
    protected function up(): void
    {
        $this->execute('CREATE TABLE `customers` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `balance` decimal(11,3) NOT NULL,
                `branch` int(11) NOT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`branch`) REFERENCES branches(`id`)
            );'
        );
    }

    protected function down(): void
    {
        $this->execute('DROP TABLE `customers`;');
    }
}
