<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210522165759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guild (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_75407DAB7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guild_member (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, guild_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_7FD58C977597D3FE (member_id), INDEX IDX_7FD58C975F2131EF (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guild ADD CONSTRAINT FK_75407DAB7E3C61F9 FOREIGN KEY (owner_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE guild_member ADD CONSTRAINT FK_7FD58C977597D3FE FOREIGN KEY (member_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE guild_member ADD CONSTRAINT FK_7FD58C975F2131EF FOREIGN KEY (guild_id) REFERENCES guild (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guild_member DROP FOREIGN KEY FK_7FD58C975F2131EF');
        $this->addSql('DROP TABLE guild');
        $this->addSql('DROP TABLE guild_member');
    }
}
