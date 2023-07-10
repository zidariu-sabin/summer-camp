<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710063732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matches (id INT AUTO_INCREMENT NOT NULL, team1_id INT NOT NULL, team2_id INT NOT NULL, score1 INT NOT NULL, score2 INT NOT NULL, INDEX IDX_62615BAE72BCFA4 (team1_id), INDEX IDX_62615BAF59E604A (team2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matches_referees (matches_id INT NOT NULL, referees_id INT NOT NULL, INDEX IDX_3EEF3F934B30DD19 (matches_id), INDEX IDX_3EEF3F93DFE3779D (referees_id), PRIMARY KEY(matches_id, referees_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `member` (id INT AUTO_INCREMENT NOT NULL, team_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, age INT NOT NULL, INDEX IDX_70E4FA78B842D717 (team_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referees (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, start_date VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, investment VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor_team (sponsor_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_2442E5FF12F7FB51 (sponsor_id), INDEX IDX_2442E5FF296CD8AE (team_id), PRIMARY KEY(sponsor_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, coach VARCHAR(255) NOT NULL, sponsor VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAE72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE matches ADD CONSTRAINT FK_62615BAF59E604A FOREIGN KEY (team2_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE matches_referees ADD CONSTRAINT FK_3EEF3F934B30DD19 FOREIGN KEY (matches_id) REFERENCES matches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE matches_referees ADD CONSTRAINT FK_3EEF3F93DFE3779D FOREIGN KEY (referees_id) REFERENCES referees (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `member` ADD CONSTRAINT FK_70E4FA78B842D717 FOREIGN KEY (team_id_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE sponsor_team ADD CONSTRAINT FK_2442E5FF12F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sponsor_team ADD CONSTRAINT FK_2442E5FF296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BAE72BCFA4');
        $this->addSql('ALTER TABLE matches DROP FOREIGN KEY FK_62615BAF59E604A');
        $this->addSql('ALTER TABLE matches_referees DROP FOREIGN KEY FK_3EEF3F934B30DD19');
        $this->addSql('ALTER TABLE matches_referees DROP FOREIGN KEY FK_3EEF3F93DFE3779D');
        $this->addSql('ALTER TABLE `member` DROP FOREIGN KEY FK_70E4FA78B842D717');
        $this->addSql('ALTER TABLE sponsor_team DROP FOREIGN KEY FK_2442E5FF12F7FB51');
        $this->addSql('ALTER TABLE sponsor_team DROP FOREIGN KEY FK_2442E5FF296CD8AE');
        $this->addSql('DROP TABLE matches');
        $this->addSql('DROP TABLE matches_referees');
        $this->addSql('DROP TABLE `member`');
        $this->addSql('DROP TABLE referees');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE sponsor_team');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
