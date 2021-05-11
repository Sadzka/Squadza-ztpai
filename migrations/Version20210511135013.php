<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210511135013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('CREATE OR TABLE item_comment (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_9F297438126F525E (item_id), INDEX IDX_9F297438A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('ALTER TABLE item_comment ADD CONSTRAINT FK_9F297438126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        // $this->addSql('ALTER TABLE item_comment ADD CONSTRAINT FK_9F297438A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        // $this->addSql('ALTER TABLE article_comment DROP FOREIGN KEY FK_79A616DB7294869C');
        // $this->addSql('ALTER TABLE article_comment DROP FOREIGN KEY FK_79A616DBF8697D13');
        // $this->addSql('DROP INDEX FK_79A616DB7294869C ON article_comment');
        // $this->addSql('ALTER TABLE article_comment DROP FOREIGN KEY FK_79A616DBF8697D13');
        // $this->addSql('ALTER TABLE article_comment ADD comment_id INT DEFAULT NULL, DROP user_id, CHANGE article_id article_id INT DEFAULT NULL');
        // $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DB7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        // $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DBF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        // $this->addSql('CREATE UNIQUE INDEX UNIQ_79A616DBF8697D13 ON article_comment (comment_id)');
        // $this->addSql('DROP INDEX fk_79a616dbf8697d13 ON article_comment');
        // $this->addSql('CREATE INDEX IDX_79A616DB7294869C ON article_comment (article_id)');
        // $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DBF8697D13 FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE item_comment');
        $this->addSql('ALTER TABLE article_comment DROP FOREIGN KEY FK_79A616DBF8697D13');
        $this->addSql('ALTER TABLE article_comment DROP FOREIGN KEY FK_79A616DB7294869C');
        $this->addSql('DROP INDEX UNIQ_79A616DBF8697D13 ON article_comment');
        $this->addSql('ALTER TABLE article_comment DROP FOREIGN KEY FK_79A616DB7294869C');
        $this->addSql('ALTER TABLE article_comment ADD user_id INT NOT NULL, DROP comment_id, CHANGE article_id article_id INT NOT NULL');
        $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DB7294869C FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX FK_79A616DB7294869C ON article_comment (user_id)');
        $this->addSql('DROP INDEX idx_79a616db7294869c ON article_comment');
        $this->addSql('CREATE INDEX FK_79A616DBF8697D13 ON article_comment (article_id)');
        $this->addSql('ALTER TABLE article_comment ADD CONSTRAINT FK_79A616DB7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }
}
