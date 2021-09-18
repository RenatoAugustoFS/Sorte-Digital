<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210918131335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cartela ADD status_vencedor TINYINT(1) NOT NULL, ADD valor_premio DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE concurso CHANGE restricao_dezenas_por_cartela quantidade_dezenas_por_cartela_dezenas_por_cartela INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cartela DROP status_vencedor, DROP valor_premio');
        $this->addSql('ALTER TABLE concurso CHANGE quantidade_dezenas_por_cartela_dezenas_por_cartela restricao_dezenas_por_cartela INT NOT NULL');
    }
}
