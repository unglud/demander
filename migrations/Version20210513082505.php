<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513082505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transport');
        $this->addSql('ALTER TABLE equipment ADD location_id_id INT NOT NULL, ADD amount INT NOT NULL, ADD location VARCHAR(255) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D583918DB72 FOREIGN KEY (location_id_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_D338D583918DB72 ON equipment (location_id_id)');
        $this->addSql('ALTER TABLE `order` DROP INDEX UNIQ_F52993982FF5EABB, ADD INDEX IDX_F52993982FF5EABB (end_station_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939853721DCB');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982D586782');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982FF5EABB');
        $this->addSql('DROP INDEX UNIQ_F52993982D586782 ON `order`');
        $this->addSql('DROP INDEX UNIQ_F529939853721DCB ON `order`');
        $this->addSql('ALTER TABLE `order` ADD start_location_id INT NOT NULL, ADD start_date DATETIME NOT NULL, ADD end_date DATETIME NOT NULL, DROP start_station_id, DROP end_date_id, CHANGE end_station_id end_station_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993985C3A313A FOREIGN KEY (start_location_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982FF5EABB FOREIGN KEY (end_station_id) REFERENCES station (id)');
        $this->addSql('CREATE INDEX IDX_F52993985C3A313A ON `order` (start_location_id)');
        $this->addSql('ALTER TABLE station CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, identifier LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, alternate_name LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, same_as LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, disambiguating_description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, url LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, additional_type LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, main_entity_of_page LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D583918DB72');
        $this->addSql('DROP INDEX IDX_D338D583918DB72 ON equipment');
        $this->addSql('ALTER TABLE equipment DROP location_id_id, DROP amount, DROP location, CHANGE name name LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` DROP INDEX IDX_F52993982FF5EABB, ADD UNIQUE INDEX UNIQ_F52993982FF5EABB (end_station_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993985C3A313A');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993982FF5EABB');
        $this->addSql('DROP INDEX IDX_F52993985C3A313A ON `order`');
        $this->addSql('ALTER TABLE `order` ADD end_date_id INT NOT NULL, DROP start_date, DROP end_date, CHANGE end_station_id end_station_id INT NOT NULL, CHANGE start_location_id start_station_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939853721DCB FOREIGN KEY (start_station_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982D586782 FOREIGN KEY (end_date_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993982FF5EABB FOREIGN KEY (end_station_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993982D586782 ON `order` (end_date_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939853721DCB ON `order` (start_station_id)');
        $this->addSql('ALTER TABLE station CHANGE name name LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
