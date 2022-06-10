<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609141709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse ADD reponse_id INT NOT NULL, ADD answer VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7CF18BB82 FOREIGN KEY (reponse_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7CF18BB82 ON reponse (reponse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7CF18BB82');
        $this->addSql('DROP INDEX IDX_5FB6DEC7CF18BB82 ON reponse');
        $this->addSql('ALTER TABLE reponse DROP reponse_id, DROP answer');
    }
}
