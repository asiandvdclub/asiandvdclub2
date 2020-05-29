import sys
import json
import re
import os
import requests
from bs4 import BeautifulSoup
def div_split(text):
    result = re.search('>;(.*)<', text)
    return result
config = {
    "title" : "",
    "title_jp" : "",
    "synopsis" : "",
    "type" : "",
    "year" : "",
    "directors" : "",
    "url" : ""
}
if len(sys.argv) != 2:
    print(json.dumps({"error":"AniDB link empty"}))
    quit(0);
headers = {'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36'}

id = sys.argv[1]
url = requests.get("https://anidb.net/anime/" + id, headers=headers)
soup = BeautifulSoup(url.content, 'html.parser')
config.update(synopsis = soup.find("div", {"class": "g_bubble g_section desc resized"}).text)
text = soup.find("tr", {"class":"type"})
config.update(type = text.findAll("td", {"class":"value"})[0].text)
text = soup.find("tr", {"class":"official verified yes"})
config.update(title = text.findAll("label")[0].text)
text = soup.find("tr", {"class":"g_odd official verified no"})
if(text.findAll("span", {"title" : "language: japanese"})[0].text == "ja"):
    config.update(title_jp = text.findAll("label")[0].text)
text = soup.find("tr", {"class":"g_odd year"})
config.update(year = text.findAll("td", {"class":"value"})[0].text)
text = soup.find("a", {"itemprop":"director"})
directors = []
for names in text.findAll("span", {"itemprop":"name"}):
    directors.append(names.text)
config.update(directors = directors)
config.update(url = soup.find("picture", "img"))
text = soup.find("picture")
config.update(url = text.findAll("img")[0]['src'])
print(json.dumps(config))