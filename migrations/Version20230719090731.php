<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719090731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE display_time_period display_time_period VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE degre_of_alcohol degre_of_alcohol VARCHAR(255) DEFAULT NULL, CHANGE capacity capacity VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE employee_number employee_number VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE display_time_period display_time_period INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE employee_number employee_number INT NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE degre_of_alcohol degre_of_alcohol INT DEFAULT NULL, CHANGE capacity capacity INT NOT NULL');
    }
}
