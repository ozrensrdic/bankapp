<?php

namespace Migration;

use Phoenix\Migration\AbstractMigration;

class CreateTransactionsTable extends AbstractMigration
{
    protected function up(): void
    {
        $this->execute('CREATE TABLE `transactions` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `sender_customer_id` int(11) NOT NULL,
                `sender_branch_id` int(11) NOT NULL,
                `receiver_sender_id` int(11) NOT NULL,
                `receiver_branch_id` int(11) NOT NULL,
                `balance_sent` decimal(11,2) NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT NOW(),
                PRIMARY KEY (`id`),
                FOREIGN KEY (`sender_customer_id`) REFERENCES customers(`id`),
                FOREIGN KEY (`receiver_sender_id`) REFERENCES customers(`id`),
                FOREIGN KEY (`sender_branch_id`) REFERENCES branches(`id`),
                FOREIGN KEY (`receiver_branch_id`) REFERENCES branches(`id`)
            );'
        );
    }

    protected function down(): void
    {
        $this->execute('DROP TABLE `transactions`;');
    }
}
