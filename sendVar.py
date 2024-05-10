import requests
import json

url = 'http://localhost/fwanderer/credentials-post-handler.php'
data = {'name': 'wadaw', 'score': 10}

response = requests.post(url, data=json.dumps(data), headers={'Content-Type': 'application/json'})

print(response.status_code)