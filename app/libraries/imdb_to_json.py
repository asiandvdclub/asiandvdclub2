from imdb import IMDb
import sys
import json

x = {
  "name": "",
  "genre": "",
  "year": 0,
  "country" : "",
  "directors" : "",
  "synopsis": ""
}
if len(sys.argv) != 2:
    print(json.dumps({"error":"Imdb link empty"}))
    quit(0);
direct = []
imdb = IMDb()
movie = imdb.get_movie(sys.argv[1]);
for director in movie['directors']:
    direct.append(director['name'])

x.update(name = movie.get('title'))
x.update(genre = movie.get('genre'))
x.update(year = movie.get('year'))
x.update(country = movie.get('country'))
x.update(directors = direct)
x.update(synopsis = movie.get('synopsis'))

print(json.dumps(x))

# the result is a JSON string:

