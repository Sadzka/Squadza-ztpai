<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210521134028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, npc_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, map VARCHAR(255) NOT NULL, INDEX IDX_5E9E89CBCA7D6B89 (npc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE npc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, x INT NOT NULL, y INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBCA7D6B89 FOREIGN KEY (npc_id) REFERENCES npc (id)');
        $this->addSql('ALTER TABLE item_comment DROP INDEX IDX_9F297438F8697D13, ADD UNIQUE INDEX UNIQ_9F297438F8697D13 (comment_id)');
        $this->addSql('ALTER TABLE item_comment DROP FOREIGN KEY FK_9F297438126F525F');
        $this->addSql('ALTER TABLE item_comment ADD CONSTRAINT FK_9F297438F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBCA7D6B89');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE npc');
        $this->addSql('ALTER TABLE item_comment DROP INDEX UNIQ_9F297438F8697D13, ADD INDEX IDX_9F297438F8697D13 (comment_id)');
        $this->addSql('ALTER TABLE item_comment DROP FOREIGN KEY FK_9F297438F8697D13');
        $this->addSql('ALTER TABLE item_comment ADD CONSTRAINT FK_9F297438126F525F FOREIGN KEY (comment_id) REFERENCES comment (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
