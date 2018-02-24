use moviedb;

# Show detailed information and ratings about movie "Inception"
select * from title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst where primaryTitle = 'Inception' and titleType = 'movie';



# Show directer information about the directer of movie "Inception"
select * from title_crew inner join name_basics on title_crew.directors = name_basics.nconst where tconst = (select tconst from title_basics where primaryTitle = 'Inception' and titleType = 'movie');



# Show principal cast/crew information about movie "Inception"
select * from title_principals inner join name_basics on title_principals.nconst=name_basics.nconst where tconst = (select tconst from title_basics where primaryTitle = 'Inception' and titleType = 'movie');



# Show information about top-10 ranking of comedy movie
select * from title_basics inner join title_ratings on title_basics.tconst = title_ratings.tconst where genres='Comedy' and titleType='movie'  and numVotes > 100 order by averageRating desc limit 0, 10;

