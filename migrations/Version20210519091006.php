<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519091006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payement (id INT AUTO_INCREMENT NOT NULL, montant INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, participant_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('DROP INDEX campaign_id ON participants');
        $this->addSql('ALTER TABLE participants CHANGE campaign_id campaign_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE payement');
        $this->addSql('ALTER TABLE participants CHANGE campaign_id campaign_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX campaign_id ON participants (campaign_id)');
    }
}
