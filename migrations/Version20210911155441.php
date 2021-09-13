<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210911155441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cartela (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, dezenas LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', pontos INT NOT NULL, status_pagamento TINYINT(1) NOT NULL, jogador_nome VARCHAR(255) NOT NULL, jogador_telefone_numero VARCHAR(255) NOT NULL, jogador_email_email VARCHAR(255) NOT NULL, INDEX IDX_3E34AD33F415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso (id INT AUTO_INCREMENT NOT NULL, premiacao_id INT DEFAULT NULL, descricao VARCHAR(255) NOT NULL, estado ENUM(\'aberto\', \'emandamento\', \'fechado\') COMMENT \'(DC2Type:enumestadoconcurso)\' NOT NULL COMMENT \'(DC2Type:enumestadoconcurso)\', periodo_data_abertura DATETIME NOT NULL, periodo_data_encerramento DATETIME DEFAULT NULL, restricao_dezenas_por_cartela INT NOT NULL, UNIQUE INDEX UNIQ_785F9DE6512121D1 (premiacao_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE premiacao (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, valor_arrecadado DOUBLE PRECISION NOT NULL, premio_mais_pontos DOUBLE PRECISION NOT NULL, arrecadacao_banca DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_69F9E85CF415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorteio_oficial (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, dezenas LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', numero_concurso_oficial INT NOT NULL, tipo VARCHAR(255) NOT NULL, INDEX IDX_85F45BD6F415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cartela ADD CONSTRAINT FK_3E34AD33F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE concurso ADD CONSTRAINT FK_785F9DE6512121D1 FOREIGN KEY (premiacao_id) REFERENCES premiacao (id)');
        $this->addSql('ALTER TABLE premiacao ADD CONSTRAINT FK_69F9E85CF415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE sorteio_oficial ADD CONSTRAINT FK_85F45BD6F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cartela DROP FOREIGN KEY FK_3E34AD33F415D168');
        $this->addSql('ALTER TABLE premiacao DROP FOREIGN KEY FK_69F9E85CF415D168');
        $this->addSql('ALTER TABLE sorteio_oficial DROP FOREIGN KEY FK_85F45BD6F415D168');
        $this->addSql('ALTER TABLE concurso DROP FOREIGN KEY FK_785F9DE6512121D1');
        $this->addSql('DROP TABLE cartela');
        $this->addSql('DROP TABLE concurso');
        $this->addSql('DROP TABLE premiacao');
        $this->addSql('DROP TABLE sorteio_oficial');
    }
}
