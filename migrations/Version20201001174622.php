<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201001174622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_E8FF75CC12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__faq AS SELECT id, category_id, question, response FROM faq');
        $this->addSql('DROP TABLE faq');
        $this->addSql('CREATE TABLE faq (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, question VARCHAR(255) NOT NULL COLLATE BINARY, response CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_E8FF75CC12469DE2 FOREIGN KEY (category_id) REFERENCES faq_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO faq (id, category_id, question, response) SELECT id, category_id, question, response FROM __temp__faq');
        $this->addSql('DROP TABLE __temp__faq');
        $this->addSql('CREATE INDEX IDX_E8FF75CC12469DE2 ON faq (category_id)');
        $this->addSql('DROP INDEX IDX_27B31AEBF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__fc_category AS SELECT id, author_id, created_at, topic FROM fc_category');
        $this->addSql('DROP TABLE fc_category');
        $this->addSql('CREATE TABLE fc_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, created_at DATETIME NOT NULL, topic CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_27B31AEBF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO fc_category (id, author_id, created_at, topic) SELECT id, author_id, created_at, topic FROM __temp__fc_category');
        $this->addSql('DROP TABLE __temp__fc_category');
        $this->addSql('CREATE INDEX IDX_27B31AEBF675F31B ON fc_category (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_E8FF75CC12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__faq AS SELECT id, category_id, question, response FROM faq');
        $this->addSql('DROP TABLE faq');
        $this->addSql('CREATE TABLE faq (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER NOT NULL, question VARCHAR(255) NOT NULL, response CLOB NOT NULL)');
        $this->addSql('INSERT INTO faq (id, category_id, question, response) SELECT id, category_id, question, response FROM __temp__faq');
        $this->addSql('DROP TABLE __temp__faq');
        $this->addSql('CREATE INDEX IDX_E8FF75CC12469DE2 ON faq (category_id)');
        $this->addSql('DROP INDEX IDX_27B31AEBF675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__fc_category AS SELECT id, author_id, topic, created_at FROM fc_category');
        $this->addSql('DROP TABLE fc_category');
        $this->addSql('CREATE TABLE fc_category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, topic CLOB NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO fc_category (id, author_id, topic, created_at) SELECT id, author_id, topic, created_at FROM __temp__fc_category');
        $this->addSql('DROP TABLE __temp__fc_category');
        $this->addSql('CREATE INDEX IDX_27B31AEBF675F31B ON fc_category (author_id)');
    }
}
