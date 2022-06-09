<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529193926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add Admin user into base';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO user (email, roles, password, display_name) VALUES ('strentz.paul@gmail.com', '[\"ROLE_ADMIN\"]', '\$2y\$13\$PpPBTHFFnOI2tteaR8IFWuKZLSI6QV6ZdBVmaWO2EnFvvF0jXt/Ny', 'Paul STRENTZ')");
    }

    public function down(Schema $schema): void
    {
    }
}
