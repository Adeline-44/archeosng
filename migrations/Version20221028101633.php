<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028101633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profession ADD code_id INT NOT NULL');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT FK_BA930D6927DAFE17 FOREIGN KEY (code_id) REFERENCES working_period (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA930D6927DAFE17 ON profession (code_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profession DROP FOREIGN KEY FK_BA930D6927DAFE17');
        $this->addSql('DROP INDEX UNIQ_BA930D6927DAFE17 ON profession');
        $this->addSql('ALTER TABLE profession DROP code_id');
    }
}
