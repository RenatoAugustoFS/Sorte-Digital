<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210820142206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cartela (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, dezenas LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', jogador_nome VARCHAR(255) NOT NULL, jogador_telefone_numero VARCHAR(255) NOT NULL, jogador_email_email VARCHAR(255) NOT NULL, INDEX IDX_3E34AD33F415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, dezenas_permitidas_por_cartela INT NOT NULL, estado_descricao VARCHAR(255) NOT NULL, periodo_data_abertura DATETIME NOT NULL, periodo_data_encerramento DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cartela ADD CONSTRAINT FK_3E34AD33F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cartela DROP FOREIGN KEY FK_3E34AD33F415D168');
        $this->addSql('DROP TABLE cartela');
        $this->addSql('DROP TABLE concurso');
    }
}
