<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230711140314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, director_lastname VARCHAR(255) NOT NULL, director_firstname VARCHAR(255) NOT NULL, siret INT NOT NULL, user_position INT NOT NULL, adress VARCHAR(255) NOT NULL, postal_code INT NOT NULL, city VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, display_time_period INT NOT NULL, theme VARCHAR(255) NOT NULL, image VARCHAR(500) NOT NULL, description VARCHAR(550) NOT NULL, INDEX IDX_5387574A32119A01 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, style VARCHAR(255) NOT NULL, customer_description VARCHAR(550) NOT NULL, employee_description VARCHAR(550) NOT NULL, degre_of_alcool INT NOT NULL, origin VARCHAR(255) NOT NULL, capacity VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, promotion INT DEFAULT NULL, stock INT DEFAULT NULL, threshold INT NOT NULL, INDEX IDX_B3BA5A5A38B53C32 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, test VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, user_position INT NOT NULL, employee_number INT NOT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, INDEX IDX_1483A5E932119A01 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A32119A01 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A38B53C32 FOREIGN KEY (company_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E932119A01 FOREIGN KEY (company_id) REFERENCES companies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A32119A01');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A38B53C32');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E932119A01');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
