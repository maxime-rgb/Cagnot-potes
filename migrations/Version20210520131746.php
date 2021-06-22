<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520131746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY participants_ibfk_1');
        $this->addSql('DROP INDEX campaign_id ON participants');
        $this->addSql('ALTER TABLE participants CHANGE campaign_id campaign_id_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970923141FA38 FOREIGN KEY (campaign_id_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX IDX_716970923141FA38 ON participants (campaign_id_id)');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY payement_ibfk_1');
        $this->addSql('DROP INDEX participant_id ON payement');
        $this->addSql('ALTER TABLE payement CHANGE participant_id participant_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A7885BEF137EE FOREIGN KEY (participant_id_id) REFERENCES participants (id)');
        $this->addSql('CREATE INDEX IDX_B20A7885BEF137EE ON payement (participant_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970923141FA38');
        $this->addSql('DROP INDEX IDX_716970923141FA38 ON participants');
        $this->addSql('ALTER TABLE participants CHANGE campaign_id_id campaign_id VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT participants_ibfk_1 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX campaign_id ON participants (campaign_id)');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A7885BEF137EE');
        $this->addSql('DROP INDEX IDX_B20A7885BEF137EE ON payement');
        $this->addSql('ALTER TABLE payement CHANGE participant_id_id participant_id INT NOT NULL');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT payement_ibfk_1 FOREIGN KEY (participant_id) REFERENCES participants (id)');
        $this->addSql('CREATE INDEX participant_id ON payement (participant_id)');
    }
}
