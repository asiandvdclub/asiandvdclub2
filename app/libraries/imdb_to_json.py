from imdb import IMDb
import sys
import json
import os

def url_clean(url):
    base, ext = os.path.splitext(url)
    i = url.count('@')
    s2 = url.split('@')[0]
    url = s2 + '@' * i + ext
    return url

x = {
  "name": "",
  "genre": "",
  "year": 0,
  "country" : "",
  "directors" : "",
  "synopsis": "",
  "plot" : "",
  "url" : ""
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
x.update(plot = movie.get('plot'))
x.update(url = url_clean(movie.get('cover')))
# the result is a JSON string
print(json.dumps(x))



