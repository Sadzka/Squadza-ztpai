<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421140416 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_comment (id INT AUTO_INCREMENT NOT NULL, article_id_id INT NOT NULL, user_id_id INT DEFAULT NULL, comment VARCHAR(1024) NOT NULL, date DATETIME NOT NULL, last_edit DATETIME DEFAULT NULL, INDEX IDX_79A616DB8F3EC46 (article_id_id), INDEX IDX_79A616DB9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DB8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DB9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_comment');
    }
}
