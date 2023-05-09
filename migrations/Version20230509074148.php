<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509074148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cv_forfait (cv_id INT NOT NULL, forfait_id INT NOT NULL, INDEX IDX_F03C97CCCFE419E2 (cv_id), INDEX IDX_F03C97CC906D5F2C (forfait_id), PRIMARY KEY(cv_id, forfait_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forfait (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cv_forfait ADD CONSTRAINT FK_F03C97CCCFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cv_forfait ADD CONSTRAINT FK_F03C97CC906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD forfait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649906D5F2C FOREIGN KEY (forfait_id) REFERENCES forfait (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649906D5F2C ON user (forfait_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649906D5F2C');
        $this->addSql('ALTER TABLE cv_forfait DROP FOREIGN KEY FK_F03C97CCCFE419E2');
        $this->addSql('ALTER TABLE cv_forfait DROP FOREIGN KEY FK_F03C97CC906D5F2C');
        $this->addSql('DROP TABLE cv_forfait');
        $this->addSql('DROP TABLE forfait');
        $this->addSql('DROP INDEX IDX_8D93D649906D5F2C ON `user`');
        $this->addSql('ALTER TABLE `user` DROP forfait_id');
    }
}
