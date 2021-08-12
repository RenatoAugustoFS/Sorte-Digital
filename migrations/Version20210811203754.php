<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210811203754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso DROP FOREIGN KEY FK_785F9DE69F5A440B');
        $this->addSql('CREATE TABLE aberto (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE em_andamento (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fechado (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE estado_concurso');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estado_concurso (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE aberto');
        $this->addSql('DROP TABLE em_andamento');
        $this->addSql('DROP TABLE fechado');
        $this->addSql('ALTER TABLE concurso ADD CONSTRAINT FK_785F9DE69F5A440B FOREIGN KEY (estado_id) REFERENCES estado_concurso (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
