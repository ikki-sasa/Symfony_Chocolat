<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720204300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse ADD fk_comment_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7B2947364 FOREIGN KEY (fk_comment_id_id) REFERENCES comment (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FB6DEC7B2947364 ON reponse (fk_comment_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7B2947364');
        $this->addSql('DROP INDEX UNIQ_5FB6DEC7B2947364 ON reponse');
        $this->addSql('ALTER TABLE reponse DROP fk_comment_id_id');
    }
}
