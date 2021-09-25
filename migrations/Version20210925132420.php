<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925132420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cartela (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, dezenas LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', pontos INT NOT NULL, status_pagamento TINYINT(1) NOT NULL, jogador_nome VARCHAR(255) NOT NULL, jogador_telefone_numero VARCHAR(255) NOT NULL, jogador_email_email VARCHAR(255) NOT NULL, INDEX IDX_3E34AD33F415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, estado ENUM(\'Aberto\', \'Em Andamento\', \'Fechado\') COMMENT \'(DC2Type:enumestadoconcurso)\' NOT NULL COMMENT \'(DC2Type:enumestadoconcurso)\', periodo_data_abertura DATETIME NOT NULL, periodo_data_encerramento DATETIME DEFAULT NULL, dezenas_por_cartela_dezenas_por_cartela INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE premiacao (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, valor_arrecadado DOUBLE PRECISION NOT NULL, premio_mais_pontos DOUBLE PRECISION NOT NULL, arrecadacao_banca DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_69F9E85CF415D168 (concurso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorteio_oficial (id INT AUTO_INCREMENT NOT NULL, dezenas LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', numero_concurso_oficial INT NOT NULL, data_concurso DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sorteio_oficial_concurso (sorteio_oficial_id INT NOT NULL, concurso_id INT NOT NULL, INDEX IDX_E7829404CDA3EAD (sorteio_oficial_id), INDEX IDX_E7829404F415D168 (concurso_id), PRIMARY KEY(sorteio_oficial_id, concurso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vencedor (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, cartela_id INT DEFAULT NULL, premio DOUBLE PRECISION NOT NULL, INDEX IDX_25B7443EF415D168 (concurso_id), UNIQUE INDEX UNIQ_25B7443E7A71A8D6 (cartela_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cartela ADD CONSTRAINT FK_3E34AD33F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE premiacao ADD CONSTRAINT FK_69F9E85CF415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE sorteio_oficial_concurso ADD CONSTRAINT FK_E7829404CDA3EAD FOREIGN KEY (sorteio_oficial_id) REFERENCES sorteio_oficial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorteio_oficial_concurso ADD CONSTRAINT FK_E7829404F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vencedor ADD CONSTRAINT FK_25B7443EF415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE vencedor ADD CONSTRAINT FK_25B7443E7A71A8D6 FOREIGN KEY (cartela_id) REFERENCES cartela (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vencedor DROP FOREIGN KEY FK_25B7443E7A71A8D6');
        $this->addSql('ALTER TABLE cartela DROP FOREIGN KEY FK_3E34AD33F415D168');
        $this->addSql('ALTER TABLE premiacao DROP FOREIGN KEY FK_69F9E85CF415D168');
        $this->addSql('ALTER TABLE sorteio_oficial_concurso DROP FOREIGN KEY FK_E7829404F415D168');
        $this->addSql('ALTER TABLE vencedor DROP FOREIGN KEY FK_25B7443EF415D168');
        $this->addSql('ALTER TABLE sorteio_oficial_concurso DROP FOREIGN KEY FK_E7829404CDA3EAD');
        $this->addSql('DROP TABLE cartela');
        $this->addSql('DROP TABLE concurso');
        $this->addSql('DROP TABLE premiacao');
        $this->addSql('DROP TABLE sorteio_oficial');
        $this->addSql('DROP TABLE sorteio_oficial_concurso');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vencedor');
    }
}
