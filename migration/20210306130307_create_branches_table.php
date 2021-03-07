<?php

namespace Migration;

use Phoenix\Migration\AbstractMigration;

class CreateBranchesTable extends AbstractMigration
{
    protected function up(): void
    {
        $this->execute('CREATE TABLE `branches` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `location` varchar(255) NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT NOW(),
                PRIMARY KEY (`id`)
            );'
        );
    }

    protected function down(): void
    {
        $this->execute('DROP TABLE `branches`;');
    }
}
