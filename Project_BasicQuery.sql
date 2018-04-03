use moviedb;

# Show detailed information and ratings about movie "Inception"
select * from (title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst) where primaryTitle = 'Inception' and titleType = 'movie';



# Show directer information about the directer of movie "Inception"
select * from title_crew left outer join name_basics on title_crew.directors = name_basics.nconst where tconst = (select tconst from title_basics where primaryTitle = 'Inception' and titleType = 'movie');



# Show principal cast/crew information about movie "Inception"
select * from title_principals left outer join name_basics on title_principals.nconst=name_basics.nconst where tconst = (select tconst from title_basics where primaryTitle = 'Inception' and titleType = 'movie');



# Show information about top-10 ranking of comedy movie
select * from title_basics left outer join title_ratings on title_basics.tconst = title_ratings.tconst where genres='Comedy' and titleType='movie'  and numVotes > 100 order by averageRating desc limit 0, 10;



drop view if exists director;
create view director as select * from name_basics;



drop view if exists writer;
create view writer as select * from name_basics;



drop view if exists actor;
create view actor as select * from name_basics;



# Create movie_info view to get basic information of a movie more convenient
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



# Create index on title_basics.primaryTitle
create index titleName_index on title_basics(primaryTitle);

# Show the result for Inception after we create index on primaryTitle, we can see it become much faster
select * from movie_info where title = 'Inception';

alter table title_basics drop index titleName_index;