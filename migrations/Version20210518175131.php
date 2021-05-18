<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518175131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD scheduled_pickup_date DATETIME DEFAULT NULL, ADD scheduled_return_date DATETIME DEFAULT NULL, ADD returned_date DATETIME DEFAULT NULL, DROP scheduled_return, DROP returned_date_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD scheduled_return DATETIME DEFAULT NULL, ADD returned_date_time DATETIME DEFAULT NULL, DROP scheduled_pickup_date, DROP scheduled_return_date, DROP returned_date');
    }
}
