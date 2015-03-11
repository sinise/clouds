import urllib
import urllib2

url = 'http://10.0.0.26/rpi/recvStatusRpi_action/11:11:11:11:11:11'
user_agent = 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT)'
values = {'ip' : '10.0.0.1',
          'mac' : '11.11.11.11.11.11',
          'wan' : '10.0.0.2',
          'cpu' : '50',
          'ram' : '400',
          'url' : 'cloudscreen.dk',
          'urlViaServer' : '0',
          'orientation' : '0',
          'lastMTransTime' : '' }
headers = { 'User-Agent' : user_agent }

data = urllib.urlencode(values)
req = urllib2.Request(url, data, headers)
response = urllib2.urlopen(req)
the_page = response.read()
print the_page
