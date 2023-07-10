<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710063858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE team_sponsor (team_id INT NOT NULL, sponsor_id INT NOT NULL, INDEX IDX_7EF5B8E3296CD8AE (team_id), INDEX IDX_7EF5B8E312F7FB51 (sponsor_id), PRIMARY KEY(team_id, sponsor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE team_sponsor ADD CONSTRAINT FK_7EF5B8E3296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_sponsor ADD CONSTRAINT FK_7EF5B8E312F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor_team DROP FOREIGN KEY FK_2442E5FF12F7FB51');
        $this->addSql('ALTER TABLE sponsor_team DROP FOREIGN KEY FK_2442E5FF296CD8AE');
        $this->addSql('DROP TABLE sponsor_team');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sponsor_team (sponsor_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_2442E5FF12F7FB51 (sponsor_id), INDEX IDX_2442E5FF296CD8AE (team_id), PRIMARY KEY(sponsor_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sponsor_team ADD CONSTRAINT FK_2442E5FF12F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor_team ADD CONSTRAINT FK_2442E5FF296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_sponsor DROP FOREIGN KEY FK_7EF5B8E3296CD8AE');
        $this->addSql('ALTER TABLE team_sponsor DROP FOREIGN KEY FK_7EF5B8E312F7FB51');
        $this->addSql('DROP TABLE team_sponsor');
    }
}
