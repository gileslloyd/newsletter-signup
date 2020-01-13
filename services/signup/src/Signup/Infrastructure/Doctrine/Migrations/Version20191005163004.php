<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191005163004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creating event_streams, projections and snapshots tables for CQRS / ES';
    }

    public function up(Schema $schema) : void
    {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

		$this->addSql('CREATE TABLE event_streams (no SERIAL NOT NULL, real_stream_name varchar(150) NOT NULL, stream_name char(41) NOT NULL, metadata json DEFAULT NULL, category varchar(150) DEFAULT NULL, PRIMARY KEY (no))');
		$this->addSql('CREATE TABLE projections (no SERIAL NOT NULL, name varchar(150) NOT NULL, position json DEFAULT NULL, state json DEFAULT NULL, status varchar(28) NOT NULL, locked_until char(26) DEFAULT NULL, PRIMARY KEY (no))');
		$this->addSql('CREATE TABLE snapshots (aggregate_id varchar(150) NOT NULL, aggregate_type varchar(150) NOT NULL, last_version int NOT NULL, created_at char(26) NOT NULL, aggregate_root bytea)');
    }

    public function down(Schema $schema) : void
    {
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

		$this->addSql('DROP TABLE event_streams');
		$this->addSql('DROP TABLE projections');
		$this->addSql('DROP TABLE snapshots');
    }
}
