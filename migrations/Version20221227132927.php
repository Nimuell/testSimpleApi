<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227132927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE message_data_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE templates_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE message (id INT NOT NULL, temptate_id INT NOT NULL, message_data_id INT NOT NULL, client_id VARCHAR(255) NOT NULL, delayed_send DATE DEFAULT NULL, message_sent TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, emails JSON NOT NULL, bcc JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307F51EBDD11 ON message (temptate_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307FA77D9B30 ON message (message_data_id)');
        $this->addSql('COMMENT ON COLUMN message.delayed_send IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN message.message_sent IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE message_data (id INT NOT NULL, subject VARCHAR(255) NOT NULL, date DATE NOT NULL, link JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN message_data.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE templates (id INT NOT NULL, template_key VARCHAR(255) NOT NULL, template VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F51EBDD11 FOREIGN KEY (temptate_id) REFERENCES templates (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA77D9B30 FOREIGN KEY (message_data_id) REFERENCES message_data (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE message_data_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE templates_id_seq CASCADE');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F51EBDD11');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FA77D9B30');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_data');
        $this->addSql('DROP TABLE templates');
    }
}
