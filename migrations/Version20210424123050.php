<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210424123050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_comment_like (id INT AUTO_INCREMENT NOT NULL, article_comment_id INT DEFAULT NULL, value SMALLINT NOT NULL, INDEX IDX_591995CEC4B0AC92 (article_comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_comment_like_user (article_comment_like_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_74839F9C952DA8BC (article_comment_like_id), INDEX IDX_74839F9CA76ED395 (user_id), PRIMARY KEY(article_comment_like_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_comment_like ADD CONSTRAINT FK_591995CEC4B0AC92 FOREIGN KEY (article_comment_id) REFERENCES article_comment (id)');
        $this->addSql('ALTER TABLE article_comment_like_user ADD CONSTRAINT FK_74839F9C952DA8BC FOREIGN KEY (article_comment_like_id) REFERENCES article_comment_like (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_comment_like_user ADD CONSTRAINT FK_74839F9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_comment_like_user DROP FOREIGN KEY FK_74839F9C952DA8BC');
        $this->addSql('DROP TABLE article_comment_like');
        $this->addSql('DROP TABLE article_comment_like_user');
    }
}
