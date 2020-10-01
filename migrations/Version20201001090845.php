<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201001090845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faq (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, question VARCHAR(255) NOT NULL, response CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_E8FF75CC12469DE2 ON faq (category_id)');
        $this->addSql('CREATE TABLE faq_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('CREATE TABLE fc_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, topic VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_27B31AEBF675F31B ON fc_category (author_id)');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE search_tracker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, question VARCHAR(255) DEFAULT NULL, faq_found_result INTEGER DEFAULT NULL, fc_found_result INTEGER DEFAULT NULL, searched_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_message_posted_at DATETIME DEFAULT NULL, last_message_posted_at DATETIME DEFAULT NULL, total_message INTEGER DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE faq');
        $this->addSql('DROP TABLE faq_category');
        $this->addSql('DROP TABLE fc_category');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE search_tracker');
        $this->addSql('DROP TABLE user');
    }
}
