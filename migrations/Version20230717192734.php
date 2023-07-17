<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230717192734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team ADD competition_wins INT NOT NULL, ADD competition_draws INT NOT NULL, ADD competition_losses INT NOT NULL, CHANGE points_scored points_scored INT DEFAULT NULL, CHANGE goal_average goal_average DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE team DROP competition_wins, DROP competition_draws, DROP competition_losses, CHANGE points_scored points_scored INT NOT NULL, CHANGE goal_average goal_average DOUBLE PRECISION NOT NULL');
    }
}
