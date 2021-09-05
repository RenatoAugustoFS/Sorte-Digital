<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210905100707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso CHANGE faturamento_id faturamento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE faturamento CHANGE concurso_id concurso_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso CHANGE faturamento_id faturamento_id INT NOT NULL');
        $this->addSql('ALTER TABLE faturamento CHANGE concurso_id concurso_id INT NOT NULL');
    }
}
