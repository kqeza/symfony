<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250316172203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__department AS SELECT id, name FROM department');
        $this->addSql('DROP TABLE department');
        $this->addSql('CREATE TABLE department (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO department (id, name) SELECT id, name FROM __temp__department');
        $this->addSql('DROP TABLE __temp__department');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, department_id, email, last_name, first_name, age, status, telegram, address FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, department_id INTEGER NOT NULL, email VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, age INTEGER NOT NULL, status VARCHAR(255) NOT NULL, telegram VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, department_id, email, last_name, first_name, age, status, telegram, address) SELECT id, department_id, email, last_name, first_name, age, status, telegram, address FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649AE80F5DF ON user (department_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__department AS SELECT id, name FROM department');
        $this->addSql('DROP TABLE department');
        $this->addSql('CREATE TABLE department (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO department (id, name) SELECT id, name FROM __temp__department');
        $this->addSql('DROP TABLE __temp__department');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD1DE18A5E237E06 ON department (name)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, last_name, first_name, age, status, email, telegram, address, department_id FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, age INTEGER NOT NULL, status VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, telegram VARCHAR(100) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, department_id INTEGER NOT NULL, CONSTRAINT FK_8D93D649AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO "user" (id, last_name, first_name, age, status, email, telegram, address, department_id) SELECT id, last_name, first_name, age, status, email, telegram, address, department_id FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D649AE80F5DF ON "user" (department_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }
}
