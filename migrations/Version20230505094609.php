<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505094609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fixture (id INT AUTO_INCREMENT NOT NULL, equipe1_id INT NOT NULL, equipe2_id INT NOT NULL, id_competition_id INT NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, encours TINYINT(1) NOT NULL, termine TINYINT(1) NOT NULL, odds_1 NUMERIC(4, 2) NOT NULL, odds_x NUMERIC(4, 2) NOT NULL, odds_2 NUMERIC(4, 2) NOT NULL, goals_equipe1 INT NOT NULL, goals_equipe2 INT NOT NULL, INDEX IDX_5E540EE4265900C (equipe1_id), INDEX IDX_5E540EE50D03FE2 (equipe2_id), INDEX IDX_5E540EE465F6E14 (id_competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fixture ADD CONSTRAINT FK_5E540EE4265900C FOREIGN KEY (equipe1_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE fixture ADD CONSTRAINT FK_5E540EE50D03FE2 FOREIGN KEY (equipe2_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE fixture ADD CONSTRAINT FK_5E540EE465F6E14 FOREIGN KEY (id_competition_id) REFERENCES competition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fixture DROP FOREIGN KEY FK_5E540EE4265900C');
        $this->addSql('ALTER TABLE fixture DROP FOREIGN KEY FK_5E540EE50D03FE2');
        $this->addSql('ALTER TABLE fixture DROP FOREIGN KEY FK_5E540EE465F6E14');
        $this->addSql('DROP TABLE fixture');
    }
}
