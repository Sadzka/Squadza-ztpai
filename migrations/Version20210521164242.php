<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210521164242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE npc_comment (id INT AUTO_INCREMENT NOT NULL, npc_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, INDEX IDX_7F9C5853CA7D6B89 (npc_id), UNIQUE INDEX UNIQ_7F9C5853F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, start_npc_id INT NOT NULL, end_npc_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, gold_reward BIGINT NOT NULL, required_level INT NOT NULL, INDEX IDX_4317F817B2FC19 (start_npc_id), INDEX IDX_4317F817BA660041 (end_npc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_comment (id INT AUTO_INCREMENT NOT NULL, quest_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, INDEX IDX_C053EF27209E9EF4 (quest_id), UNIQUE INDEX UNIQ_C053EF27F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE npc_comment ADD CONSTRAINT FK_7F9C5853CA7D6B89 FOREIGN KEY (npc_id) REFERENCES npc (id)');
        $this->addSql('ALTER TABLE npc_comment ADD CONSTRAINT FK_7F9C5853F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817B2FC19 FOREIGN KEY (start_npc_id) REFERENCES npc (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817BA660041 FOREIGN KEY (end_npc_id) REFERENCES npc (id)');
        $this->addSql('ALTER TABLE quest_comment ADD CONSTRAINT FK_C053EF27209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_comment ADD CONSTRAINT FK_C053EF27F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE item CHANGE icon icon VARCHAR(127) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest_comment DROP FOREIGN KEY FK_C053EF27209E9EF4');
        $this->addSql('DROP TABLE npc_comment');
        $this->addSql('DROP TABLE quest');
        $this->addSql('DROP TABLE quest_comment');
        $this->addSql('ALTER TABLE item CHANGE icon icon VARCHAR(127) CHARACTER SET utf8mb4 DEFAULT \'unknown\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
