create database moviedb;

use moviedb;

drop table if exists title_basics;
drop table if exists title_crew;
drop table if exists title_principals;
drop table if exists title_ratings;
drop table if exists name_basics;

create table if not exists title_basics (tconst char(10) not null, titleType varchar(100), primaryTitle varchar(500), originalTitle varchar(500), isAdult boolean, startYear char(4), endYear char(4), runtimeMinutes int, genres varchar(100), primary key (tconst));
create table if not exists title_crew (tconst char(10) not null, directors text, writers text, primary key (tconst));
create table if not exists title_principals (tconst char(10) not null, ordering int not null, nconst char(10), category varchar(100), job varchar(500), characters varchar(500), primary key (tconst, ordering));
create table if not exists title_ratings (tconst char(10) not null, averageRating numeric(3,1), numVotes int, primary key(tconst));
create table if not exists name_basics (nconst char(10) not null, primaryName varchar(200), birthYear char(4), deathYear char(4), primaryProfession varchar(100), knownForTitles varchar(100), primary key(nconst));
create table if not exists users_basics (uconst char(10) not null, primaryName varchar(50), nickName varchar(50), birthday date, primary key (uconst));
create table if not exists users_reviews (uconst char(10) not null, tconst char(10) not null, reviews text, rating numeric(3, 1));

load data local infile '/Users/fuhao/Documents/UVA Study/Database/Project/dataset/title.basics.tsv' into table title_basics fields terminated by '\t';
load data local infile '/Users/fuhao/Documents/UVA Study/Database/Project/dataset/title.crew.tsv' into table title_crew fields terminated by '\t';
load data local infile '/Users/fuhao/Documents/UVA Study/Database/Project/dataset/title.principals.tsv' into table title_principals fields terminated by '\t';
load data local infile '/Users/fuhao/Documents/UVA Study/Database/Project/dataset/title.ratings.tsv' into table title_ratings fields terminated by '\t';
load data local infile '/Users/fuhao/Documents/UVA Study/Database/Project/dataset/name.basics.tsv' into table name_basics fields terminated by '\t';