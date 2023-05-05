<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505095643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pari_singulier (id INT AUTO_INCREMENT NOT NULL, id_fixture_id INT NOT NULL, id_pari_id INT NOT NULL, choix VARCHAR(1) NOT NULL, resultat TINYINT(1) NOT NULL, INDEX IDX_2AF1B7C940AEE1BA (id_fixture_id), INDEX IDX_2AF1B7C9300D6DDE (id_pari_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pari_singulier ADD CONSTRAINT FK_2AF1B7C940AEE1BA FOREIGN KEY (id_fixture_id) REFERENCES fixture (id)');
        $this->addSql('ALTER TABLE pari_singulier ADD CONSTRAINT FK_2AF1B7C9300D6DDE FOREIGN KEY (id_pari_id) REFERENCES pari (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pari_singulier DROP FOREIGN KEY FK_2AF1B7C940AEE1BA');
        $this->addSql('ALTER TABLE pari_singulier DROP FOREIGN KEY FK_2AF1B7C9300D6DDE');
        $this->addSql('DROP TABLE pari_singulier');
    }
}
