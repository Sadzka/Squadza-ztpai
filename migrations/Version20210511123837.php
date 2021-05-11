<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511123837 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, quality SMALLINT NOT NULL, name VARCHAR(127) NOT NULL, icon VARCHAR(127) NOT NULL, item_level INT DEFAULT NULL, bind_on_pick_up TINYINT(1) DEFAULT NULL, is_unique INT DEFAULT NULL, equip_type VARCHAR(32) DEFAULT NULL, slot VARCHAR(32) DEFAULT NULL, damage_min INT DEFAULT NULL, damage_max INT DEFAULT NULL, speed DOUBLE PRECISION DEFAULT NULL, required_level INT NOT NULL, sell_price BIGINT NOT NULL, stat_type1 VARCHAR(32) DEFAULT NULL, stat_value1 INT NOT NULL, stat_type2 VARCHAR(32) DEFAULT NULL, stat_value2 INT NOT NULL, stat_type3 VARCHAR(32) DEFAULT NULL, stat_value3 INT NOT NULL, stat_type4 VARCHAR(32) DEFAULT NULL, stat_value4 INT NOT NULL, socket1 VARCHAR(32) DEFAULT NULL, socket2 VARCHAR(32) DEFAULT NULL, socket3 VARCHAR(32) DEFAULT NULL, socket_bonus_type VARCHAR(32) DEFAULT NULL, socket_bonus_value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE sequence');
        $this->addSql('DROP INDEX UNIQUE_LIKE ON article_comment_like');
        $this->addSql('ALTER TABLE article_comment_like CHANGE value value INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sequence (number BIGINT UNSIGNED NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE article_comment_like CHANGE value value TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_LIKE ON article_comment_like (article_comment_id, user_id)');
    }
}
