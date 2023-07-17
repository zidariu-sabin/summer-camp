<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716145533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition_team (competition_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_CAA3380D7B39D312 (competition_id), INDEX IDX_CAA3380D296CD8AE (team_id), PRIMARY KEY(competition_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competition_team ADD CONSTRAINT FK_CAA3380D7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competition_team ADD CONSTRAINT FK_CAA3380D296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matches ADD competition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BA7B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('CREATE INDEX IDX_62615BA7B39D312 ON matches (competition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BA7B39D312');
        $this->addSql('ALTER TABLE competition_team DROP FOREIGN KEY FK_CAA3380D7B39D312');
        $this->addSql('ALTER TABLE competition_team DROP FOREIGN KEY FK_CAA3380D296CD8AE');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE competition_team');
        $this->addSql('DROP INDEX IDX_62615BA7B39D312 ON matches');
        $this->addSql('ALTER TABLE matches DROP competition_id');
    }
}
