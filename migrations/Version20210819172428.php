<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819172428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cartela DROP FOREIGN KEY FK_3E34AD33814B85AC');
        $this->addSql('DROP TABLE jogador');
        $this->addSql('DROP INDEX IDX_3E34AD33814B85AC ON cartela');
        $this->addSql('ALTER TABLE cartela ADD jogador_nome VARCHAR(255) NOT NULL, ADD jogador_telefone_numero VARCHAR(255) NOT NULL, ADD jogador_email_email VARCHAR(255) NOT NULL, DROP jogador_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jogador (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telefone_numero VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cartela ADD jogador_id INT NOT NULL, DROP jogador_nome, DROP jogador_telefone_numero, DROP jogador_email_email');
        $this->addSql('ALTER TABLE cartela ADD CONSTRAINT FK_3E34AD33814B85AC FOREIGN KEY (jogador_id) REFERENCES jogador (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3E34AD33814B85AC ON cartela (jogador_id)');
    }
}
