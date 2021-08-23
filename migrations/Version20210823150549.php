<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823150549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso DROP FOREIGN KEY FK_785F9DE69F5A440B');
        $this->addSql('DROP TABLE estado_concurso');
        $this->addSql('DROP INDEX IDX_785F9DE69F5A440B ON concurso');
        $this->addSql('ALTER TABLE concurso ADD estado_descricao VARCHAR(255) NOT NULL, DROP estado_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estado_concurso (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, discr_column VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE concurso ADD estado_id INT DEFAULT NULL, DROP estado_descricao');
        $this->addSql('ALTER TABLE concurso ADD CONSTRAINT FK_785F9DE69F5A440B FOREIGN KEY (estado_id) REFERENCES estado_concurso (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_785F9DE69F5A440B ON concurso (estado_id)');
    }
}
