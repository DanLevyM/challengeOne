<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613065705 extends AbstractMigration
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
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, user_id_id INT NOT NULL, movie_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, date DATE NOT NULL, counter INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C10684CB ON comment (movie_id_id)');
        $this->addSql('CREATE TABLE moderation (id INT NOT NULL, user_id_id INT DEFAULT NULL, commentaire_id_id INT DEFAULT NULL, counter_user_ban INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C0EA6AA49D86650F ON moderation (user_id_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0EA6AA4FAC8564B ON moderation (commentaire_id_id)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, title VARCHAR(255) NOT NULL, director VARCHAR(255) NOT NULL, release_date DATE NOT NULL, description TEXT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movie_room (id INT NOT NULL, number_places INT NOT NULL, room_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, price INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, user_admin_id INT DEFAULT NULL, user_admin_check_id INT DEFAULT NULL, movie_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, validate BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C684A66610 ON review (user_admin_id)');
        $this->addSql('CREATE INDEX IDX_794381C68FB65DB8 ON review (user_admin_check_id)');
        $this->addSql('CREATE INDEX IDX_794381C68F93B6FC ON review (movie_id)');
        $this->addSql('CREATE TABLE seance (id INT NOT NULL, movieroom_id_id INT NOT NULL, movie_id INT DEFAULT NULL, end_time TIME(0) WITHOUT TIME ZONE NOT NULL, date DATE NOT NULL, start_time TIME(0) WITHOUT TIME ZONE NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EEBB197E7 ON seance (movieroom_id_id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E8F93B6FC ON seance (movie_id)');
        $this->addSql('CREATE TABLE subscription (id INT NOT NULL, user_sub_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, formality VARCHAR(255) NOT NULL, price INT NOT NULL, started_at DATE NOT NULL, end_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A3C664D3603B89E4 ON subscription (user_sub_id)');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, user_id_id INT NOT NULL, seance_id_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_97A0ADA39D86650F ON ticket (user_id_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA360528D1B ON ticket (seance_id_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C10684CB FOREIGN KEY (movie_id_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA49D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moderation ADD CONSTRAINT FK_C0EA6AA4FAC8564B FOREIGN KEY (commentaire_id_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C684A66610 FOREIGN KEY (user_admin_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68FB65DB8 FOREIGN KEY (user_admin_check_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C68F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EEBB197E7 FOREIGN KEY (movieroom_id_id) REFERENCES movie_room (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subscription ADD CONSTRAINT FK_A3C664D3603B89E4 FOREIGN KEY (user_sub_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA39D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA360528D1B FOREIGN KEY (seance_id_id) REFERENCES seance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE moderation DROP CONSTRAINT FK_C0EA6AA4FAC8564B');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C684A66610');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C68FB65DB8');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C68F93B6FC');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EEBB197E7');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0E8F93B6FC');
        $this->addSql('ALTER TABLE subscription DROP CONSTRAINT FK_A3C664D3603B89E4');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA39D86650F');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA360528D1B');
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
