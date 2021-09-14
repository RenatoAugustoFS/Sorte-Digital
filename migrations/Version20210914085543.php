<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914085543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vencedor (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, cartela_id INT DEFAULT NULL, premio DOUBLE PRECISION NOT NULL, INDEX IDX_25B7443EF415D168 (concurso_id), UNIQUE INDEX UNIQ_25B7443E7A71A8D6 (cartela_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vencedor ADD CONSTRAINT FK_25B7443EF415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id)');
        $this->addSql('ALTER TABLE vencedor ADD CONSTRAINT FK_25B7443E7A71A8D6 FOREIGN KEY (cartela_id) REFERENCES cartela (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vencedor');
    }
}
