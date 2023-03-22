<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028095913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE working_period ADD prof_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE working_period ADD CONSTRAINT FK_E849B23ABC1F7FE FOREIGN KEY (prof_id) REFERENCES profession (id)');
        $this->addSql('CREATE INDEX IDX_E849B23ABC1F7FE ON working_period (prof_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE working_period DROP FOREIGN KEY FK_E849B23ABC1F7FE');
        $this->addSql('DROP INDEX IDX_E849B23ABC1F7FE ON working_period');
        $this->addSql('ALTER TABLE working_period DROP prof_id');
    }
}
