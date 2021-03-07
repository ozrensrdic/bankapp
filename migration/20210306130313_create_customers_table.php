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
                `balance` decimal(11,2) NOT NULL,
                `branch_id` int(11),
                `created_at` timestamp NOT NULL DEFAULT NOW(),
                PRIMARY KEY (`id`),
                FOREIGN KEY (`branch_id`) REFERENCES branches(`id`)
            );'
        );
    }

    protected function down(): void
    {
        $this->execute('DROP TABLE `customers`;');
    }
}
