<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819171840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cartela (id INT AUTO_INCREMENT NOT NULL, jogador_id INT NOT NULL, concurso_id INT DEFAULT NULL, dezenas LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_3E34AD33814B85AC (jogador_id), INDEX IDX_3E34AD33F415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso (id INT AUTO_INCREMENT NOT NULL, estado_id INT NOT NULL, descricao VARCHAR(255) NOT NULL, data_inicio DATETIME NOT NULL, data_fim DATETIME DEFAULT NULL, dezenas_permitidas_por_cartela INT NOT NULL, INDEX IDX_785F9DE69F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_concurso (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, dtype VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jogador (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, telefone_numero VARCHAR(255) NOT NULL, email_email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cartela ADD CONSTRAINT FK_3E34AD33814B85AC FOREIGN KEY (jogador_id) REFERENCES jogador (id)');
        $this->addSql('ALTER TABLE cartela ADD CONSTRAINT FK_3E34AD33F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE concurso ADD CONSTRAINT FK_785F9DE69F5A440B FOREIGN KEY (estado_id) REFERENCES estado_concurso (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cartela DROP FOREIGN KEY FK_3E34AD33F415D168');
        $this->addSql('ALTER TABLE concurso DROP FOREIGN KEY FK_785F9DE69F5A440B');
        $this->addSql('ALTER TABLE cartela DROP FOREIGN KEY FK_3E34AD33814B85AC');
        $this->addSql('DROP TABLE cartela');
        $this->addSql('DROP TABLE concurso');
        $this->addSql('DROP TABLE estado_concurso');
        $this->addSql('DROP TABLE jogador');
    }
}
