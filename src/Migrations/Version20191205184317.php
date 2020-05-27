<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191205184317 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, writing_date DATETIME NOT NULL, updated_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, publish_date DATETIME DEFAULT NULL, INDEX IDX_DADD4A25A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, alias VARCHAR(80) NOT NULL, summary VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, topic_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(180) NOT NULL, writing_date DATETIME NOT NULL, type ENUM(\'public\', \'private\', \'admin\') NOT NULL COMMENT \'(DC2Type:enumcomment)\', INDEX IDX_9474526C1F55203D (topic_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_id INT NOT NULL, answer_id INT DEFAULT NULL, name VARCHAR(180) NOT NULL, summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, writing_date DATETIME NOT NULL, updated_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, publish_date DATETIME DEFAULT NULL, alias VARCHAR(180) NOT NULL, INDEX IDX_9D40DE1BA76ED395 (user_id), INDEX IDX_9D40DE1B12469DE2 (category_id), UNIQUE INDEX UNIQ_9D40DE1BAA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(80) NOT NULL, lastname VARCHAR(80) NOT NULL, email VARCHAR(80) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', registration_date DATETIME NOT NULL, last_connection_date DATETIME DEFAULT NULL, last_connection_ip VARCHAR(20) DEFAULT NULL, receive_notification TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BAA334807');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B12469DE2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C1F55203D');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BA76ED395');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE user');
    }
}
