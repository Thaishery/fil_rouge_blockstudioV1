<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210316112752 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, title VARCHAR(255) NOT NULL, years DATE NOT NULL, nb_of_tracks INT NOT NULL, sample VARCHAR(255) DEFAULT NULL, linkone VARCHAR(255) DEFAULT NULL, linktwo VARCHAR(255) DEFAULT NULL, linkthree VARCHAR(255) DEFAULT NULL, cover VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_50159CA973A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_user (projet_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FA413966C18272 (projet_id), INDEX IDX_FA413966A76ED395 (user_id), PRIMARY KEY(projet_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA973A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE projet_user ADD CONSTRAINT FK_FA413966C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_user ADD CONSTRAINT FK_FA413966A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_user DROP FOREIGN KEY FK_FA413966C18272');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_user');
    }
}
