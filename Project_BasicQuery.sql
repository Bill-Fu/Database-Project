use moviedb;

# insert record to mini copy of original table
insert into title_basics_mini select title_basics.* from (title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst) where numVotes > 100000 and titleType = 'movie';

insert into title_crew_mini select title_crew.* from ((title_crew inner join title_ratings on title_crew.tconst = title_ratings.tconst) inner join title_basics on title_crew.tconst = title_basics.tconst) where numVotes > 100000 and titleType = 'movie';

insert into title_ratings_mini select title_ratings.* from (title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst) where numVotes > 100000 and titleType = 'movie';

insert into title_principals_mini select title_principals.* from ((title_principals inner join title_ratings on title_principals.tconst = title_ratings.tconst) inner join title_basics on title_principals.tconst = title_basics.tconst) where numVotes > 100000 and titleType = 'movie';

insert into name_basics_mini select distinct name_basics.* from (title_principals_mini inner join name_basics on title_principals_mini.nconst = name_basics.nconst);

# basic query using mini copy to find top 10 sci-fi movie from 2000 - 2010 by rating order
select title_basics_mini.* from (title_basics_mini inner join title_ratings_mini on title_basics_mini.tconst = title_ratings_mini.tconst) where genres like '%Sci-Fi%' and startYear < 2010 and startYear >= 2000 order by averageRating desc limit 0, 10;

# order by: hot degree, rating
# category:  year: -2000, 2000-2010, 2010-
#					genre: drama, action, sci-fi, romance, fantasy, horror, comedy, crime, mystery, animation, family, history, adventure, war, thriller, biography, musical

# Show detailed information and ratings about movie "Inception"
select * from (title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst) where primaryTitle = 'Inception' and titleType = 'movie';


# Show directer information about the directer of movie "Inception"
select * from title_crew left outer join name_basics on title_crew.directors = name_basics.nconst where tconst = (select tconst from title_basics where primaryTitle = 'Inception' and titleType = 'movie');



# Show principal cast/crew information about movie "Inception"
select * from title_principals left outer join name_basics on title_principals.nconst=name_basics.nconst where tconst = (select tconst from title_basics where primaryTitle = 'Inception' and titleType = 'movie');



# Show information about top-10 hottest comedy movies
select * from title_basics left outer join title_ratings on title_basics.tconst = title_ratings.tconst where titleType='movie'  and numVotes > 100 order by numVotes desc limit 0, 10;



# Then we create three views to support our movie_info view
drop view if exists director;
create view director as select * from name_basics;

drop view if exists writer;
create view writer as select * from name_basics;

drop view if exists actor;
create view actor as select * from name_basics;

# Search the detailed information of "The Matrix"
select title_basics_mini.primaryTitle as title, title_basics_mini.startYear as startYear, title_basics_mini.runtimeMinutes as runtime, title_basics_mini.genres, title_ratings_mini.averageRating as rating, director.primaryName as director, writer.primaryName as writer, actor.primaryName as actor, title_principals_mini.characters as characters
from ((((((title_basics_mini inner join title_ratings_mini on title_basics_mini.tconst = title_ratings_mini.tconst)
left outer join title_crew_mini on title_basics_mini.tconst = title_crew_mini.tconst)
left outer join title_principals_mini on title_basics_mini.tconst = title_principals_mini.tconst)
left outer join director on title_crew_mini.directors = director.nconst)
left outer join writer on title_crew_mini.directors = writer.nconst)
left outer join actor on title_principals_mini.nconst = actor.nconst)
where title_principals_mini.characters != 'null'
and primaryTitle = 'The Matrix' limit 0, 10;


# Create movie_info view to retrieve basic information of a movie more convenient
# In movie_info view we have title, startYear, endYear, runtime, genres, rating, director, writer, actor and character
drop view if exists movie_info;
create view movie_info as 
(select title_basics.primaryTitle as title, title_basics.startYear, title_basics.endYear, title_basics.runtimeMinutes as runtime, title_basics.genres, title_ratings.averageRating as rating, director.primaryName as director, writer.primaryName as writer, actor.primaryName as actor, title_principals.characters as characters
from ((((((title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst) 
inner join title_crew on title_basics.tconst = title_crew.tconst)
inner join title_principals on title_basics.tconst = title_principals.tconst)
inner join director on title_crew.directors = director.nconst)
inner join writer on title_crew.directors = writer.nconst)
inner join actor on title_principals.nconst = actor.nconst)
where title_basics.titleType = 'movie' and title_principals.characters != 'null');

# Show the result for Inception and Titanic on our view
select * from movie_info where title = 'Inception';

select * from movie_info where title = 'Titanic' and startYear = '1997';



# Show the size of our database
select count(*) from title_basics;
select count(*) from name_basics;



# Create index on title_basics.primaryTitle because we frequently need to retrive movie information by their title
create index titleName_index on title_basics(primaryTitle);

# Show the result for Inception after we create index on primaryTitle, we can see it become much faster
select * from movie_info where title = 'Inception';

alter table title_basics drop index titleName_index;