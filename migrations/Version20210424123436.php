<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210424123436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article_comment_like_user');
        $this->addSql('ALTER TABLE article_comment_like ADD user_id INT DEFAULT NULL, CHANGE value value TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE article_comment_like ADD CONSTRAINT FK_591995CEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_591995CEA76ED395 ON article_comment_like (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_comment_like_user (article_comment_like_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_74839F9C952DA8BC (article_comment_like_id), INDEX IDX_74839F9CA76ED395 (user_id), PRIMARY KEY(article_comment_like_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article_comment_like_user ADD CONSTRAINT FK_74839F9C952DA8BC FOREIGN KEY (article_comment_like_id) REFERENCES article_comment_like (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_comment_like_user ADD CONSTRAINT FK_74839F9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_comment_like DROP FOREIGN KEY FK_591995CEA76ED395');
        $this->addSql('DROP INDEX IDX_591995CEA76ED395 ON article_comment_like');
        $this->addSql('ALTER TABLE article_comment_like DROP user_id, CHANGE value value SMALLINT NOT NULL');
    }
}
