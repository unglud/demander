<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513160919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, order_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INT NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_D338D58321BDB235 (station_id), INDEX IDX_D338D5838D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT NOT NULL, start_location_id INT NOT NULL, end_location_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_F52993985C3A313A (start_location_id), INDEX IDX_F5299398C43C7F1 (end_location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, order_id INT DEFAULT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_66AB212E21BDB235 (station_id), INDEX IDX_66AB212E8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D58321BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5838D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985C3A313A FOREIGN KEY (start_location_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C43C7F1 FOREIGN KEY (end_location_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BF396750 FOREIGN KEY (id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1BF396750 FOREIGN KEY (id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212E8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BF396750');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1BF396750');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5838D9F6D38');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E8D9F6D38');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D58321BDB235');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985C3A313A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C43C7F1');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212E21BDB235');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE station');
        $this->addSql('DROP TABLE transport');
    }
}
