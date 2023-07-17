<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716180634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches CHANGE score1 score1 INT DEFAULT NULL, CHANGE score2 score2 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD points_scored INT NOT NULL, ADD goal_average INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE matches CHANGE score1 score1 INT NOT NULL, CHANGE score2 score2 INT NOT NULL');
        $this->addSql('ALTER TABLE team DROP points_scored, DROP goal_average');
    }
}
