<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513115028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, stations_id INT NOT NULL, orders_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, amount INT NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_D338D583B1E3C4B4 (stations_id), INDEX IDX_D338D583CFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT NOT NULL, start_location_id INT NOT NULL, end_station_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, INDEX IDX_F52993985C3A313A (start_location_id), INDEX IDX_F52993982FF5EABB (end_station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE station (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583B1E3C4B4 FOREIGN KEY (stations_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985C3A313A FOREIGN KEY (start_location_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982FF5EABB FOREIGN KEY (end_station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398BF396750 FOREIGN KEY (id) REFERENCES location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE station ADD CONSTRAINT FK_9F39F8B1BF396750 FOREIGN KEY (id) REFERENCES location (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398BF396750');
        $this->addSql('ALTER TABLE station DROP FOREIGN KEY FK_9F39F8B1BF396750');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583CFFE9AD6');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583B1E3C4B4');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985C3A313A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982FF5EABB');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE station');
    }
}
