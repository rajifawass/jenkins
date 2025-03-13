import requests
import time
import sys
sys.stdout.reconfigure(encoding='utf-8')

# Configuration
ZAP_URL = "http://localhost:8081"
TARGET_URL = "http://localhost/salon/index.php"  # URL cible
API_KEY = "87n4jl3pqa2c9l119a3vt11ktt"  # Mets la bonne clé API

# Étape 1 : Explorer le site avec Spider
spider_url = f"{ZAP_URL}/JSON/spider/action/scan/?apikey={API_KEY}&url={TARGET_URL}&maxChildren=10"
spider_response = requests.get(spider_url)

if spider_response.status_code == 200:
    print("🕷️ Exploration du site en cours...")
else:
    print(f"❌ Erreur lors de l'exploration : {spider_response.text}")
    exit(1)

# Attendre quelques secondes pour que l'exploration se termine
time.sleep(5)

print("✅ Exploration du site terminée !")
