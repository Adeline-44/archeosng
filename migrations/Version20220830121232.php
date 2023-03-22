<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830121232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(255) DEFAULT NULL, adr1 VARCHAR(255) DEFAULT NULL, adr2 VARCHAR(255) DEFAULT NULL, categorie SMALLINT NOT NULL, city VARCHAR(255) DEFAULT NULL, cp VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, genre SMALLINT NOT NULL, last_name VARCHAR(255) DEFAULT NULL, militaire TINYINT(1) NOT NULL, militaire_months INT NOT NULL, month_base DOUBLE PRECISION NOT NULL, poste VARCHAR(255) DEFAULT NULL, week_base DOUBLE PRECISION NOT NULL, cadre_emploi INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE working_period (id INT AUTO_INCREMENT NOT NULL, employee_id_id INT DEFAULT NULL, end_date DATETIME DEFAULT NULL, hours DOUBLE PRECISION NOT NULL, start_date DATETIME DEFAULT NULL, type INT NOT NULL, prof VARCHAR(255) DEFAULT NULL, cat VARCHAR(1) NOT NULL, INDEX IDX_E849B239749932E (employee_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE working_period ADD CONSTRAINT FK_E849B239749932E FOREIGN KEY (employee_id_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE working_period DROP FOREIGN KEY FK_E849B239749932E');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE working_period');
    }
}
