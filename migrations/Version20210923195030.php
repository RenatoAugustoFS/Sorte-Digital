<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923195030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso DROP FOREIGN KEY FK_785F9DE6512121D1');
        $this->addSql('DROP INDEX UNIQ_785F9DE6512121D1 ON concurso');
        $this->addSql('ALTER TABLE concurso DROP premiacao_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso ADD premiacao_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concurso ADD CONSTRAINT FK_785F9DE6512121D1 FOREIGN KEY (premiacao_id) REFERENCES premiacao (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_785F9DE6512121D1 ON concurso (premiacao_id)');
    }
}
