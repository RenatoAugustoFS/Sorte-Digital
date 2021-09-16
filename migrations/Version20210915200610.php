<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210915200610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sorteio_oficial_concurso (sorteio_oficial_id INT NOT NULL, concurso_id INT NOT NULL, INDEX IDX_E7829404CDA3EAD (sorteio_oficial_id), INDEX IDX_E7829404F415D168 (concurso_id), PRIMARY KEY(sorteio_oficial_id, concurso_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sorteio_oficial_concurso ADD CONSTRAINT FK_E7829404CDA3EAD FOREIGN KEY (sorteio_oficial_id) REFERENCES sorteio_oficial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorteio_oficial_concurso ADD CONSTRAINT FK_E7829404F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sorteio_oficial DROP FOREIGN KEY FK_85F45BD6F415D168');
        $this->addSql('DROP INDEX IDX_85F45BD6F415D168 ON sorteio_oficial');
        $this->addSql('ALTER TABLE sorteio_oficial DROP concurso_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sorteio_oficial_concurso');
        $this->addSql('ALTER TABLE sorteio_oficial ADD concurso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sorteio_oficial ADD CONSTRAINT FK_85F45BD6F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_85F45BD6F415D168 ON sorteio_oficial (concurso_id)');
    }
}
