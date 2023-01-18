<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117154133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE moderation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE movie_room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE seance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, user_id_id INT NOT NULL, movie_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C10684CB ON comment (movie_id_id)');
        $this->addSql('CREATE TABLE moderation (id INT NOT NULL, user_id_id INT DEFAULT NULL, counter INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0EA6AA49D86650F ON moderation (user_id_id)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, review_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, director VARCHAR(255) NOT NULL, release_date DATE NOT NULL, description TEXT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D5EF26F6CCAB24C ON movie (review_id_id)');
        $this->addSql('CREATE TABLE movie_room (id INT NOT NULL, number_places INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, price INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, user_id_id INT DEFAULT NULL, user_verif_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C69D86650F ON review (user_id_id)');
        $this->addSql('CREATE INDEX IDX_794381C6639BCD37 ON review (user_verif_id)');
        $this->addSql('CREATE TABLE seance (id INT NOT NULL, movie_id_id INT NOT NULL, movieroom_id_id INT NOT NULL, end_time TIME(0) WITHOUT TIME ZONE NOT NULL, date DATE NOT NULL, start_time TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E10684CB ON seance (movie_id_id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EEBB197E7 ON seance (movieroom_id_id)');
        $this->addSql('CREATE TABLE subscription (id INT NOT NULL, type VARCHAR(255) NOT NULL, formality VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, user_id_id INT NOT NULL, seance_id_id INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA39D86650F ON ticket (user_id_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA360528D1B ON ticket (seance_id_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, subscription_id_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649857C9F24 ON "user" (subscription_id_id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C10684CB FOREIGN KEY (movie_id_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA49D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26F6CCAB24C FOREIGN KEY (review_id_id) REFERENCES review (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C69D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6639BCD37 FOREIGN KEY (user_verif_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E10684CB FOREIGN KEY (movie_id_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EEBB197E7 FOREIGN KEY (movieroom_id_id) REFERENCES movie_room (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA360528D1B FOREIGN KEY (seance_id_id) REFERENCES seance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649857C9F24 FOREIGN KEY (subscription_id_id) REFERENCES subscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE moderation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE movie_room_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE review_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE seance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C10684CB');
        $this->addSql('ALTER TABLE moderation DROP CONSTRAINT FK_C0EA6AA49D86650F');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26F6CCAB24C');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C69D86650F');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C6639BCD37');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0E10684CB');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EEBB197E7');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA39D86650F');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA360528D1B');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649857C9F24');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE moderation');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE movie_room');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE "user"');
    }
}
