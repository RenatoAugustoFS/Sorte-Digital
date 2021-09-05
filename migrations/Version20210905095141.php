<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210905095141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faturamento (id INT AUTO_INCREMENT NOT NULL, concurso_id INT NOT NULL, UNIQUE INDEX UNIQ_A52E00D5F415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faturamento ADD CONSTRAINT FK_A52E00D5F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE concurso ADD faturamento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concurso ADD CONSTRAINT FK_785F9DE631D53F81 FOREIGN KEY (faturamento_id) REFERENCES faturamento (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_785F9DE631D53F81 ON concurso (faturamento_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso DROP FOREIGN KEY FK_785F9DE631D53F81');
        $this->addSql('DROP TABLE faturamento');
        $this->addSql('DROP INDEX UNIQ_785F9DE631D53F81 ON concurso');
        $this->addSql('ALTER TABLE concurso DROP faturamento_id');
    }
}
