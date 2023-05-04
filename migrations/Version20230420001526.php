<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420001526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD url_web VARCHAR(255) DEFAULT NULL, ADD url_git VARCHAR(255) DEFAULT NULL, ADD url_twitter VARCHAR(255) DEFAULT NULL, ADD url_insta VARCHAR(255) DEFAULT NULL, ADD url_fb VARCHAR(255) DEFAULT NULL, CHANGE experience experience INT NOT NULL, CHANGE salaire salaire INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP url_web, DROP url_git, DROP url_twitter, DROP url_insta, DROP url_fb, CHANGE experience experience INT DEFAULT NULL, CHANGE salaire salaire INT DEFAULT NULL');
    }
}
