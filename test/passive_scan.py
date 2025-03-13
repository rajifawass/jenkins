import requests
import time
import sys
import codecs

sys.stdout = codecs.getwriter("utf-8")(sys.stdout.buffer)


# Configuration
ZAP_URL = "http://localhost:8081"
API_KEY = "87n4jl3pqa2c9l119a3vt11ktt"  # Mets ta clé API ici
TARGET_URL = "http://localhost/salon/login.php"  # URL cible

# Étape 1 : Lancer une exploration Spider avant le scan passif (optionnel mais recommandé)
print("[INFO] Démarrage du Spider...")
spider_url = f"{ZAP_URL}/JSON/spider/action/scan/"
spider_response = requests.get(spider_url, params={"apikey": API_KEY, "url": TARGET_URL, "maxChildren": "10"})

if spider_response.status_code == 200:
    print("[INFO] Spider lancé avec succès !")
else:
    print(f"[ERROR] Échec du lancement du Spider : {spider_response.text}")
    exit(1)

# Attendre un peu pour laisser le Spider explorer les pages
time.sleep(10)

# Étape 2 : Vérifier l'état du scan passif
print("[INFO] Vérification de l'état du scan passif...")

while True:
    scan_status_url = f"{ZAP_URL}/JSON/pscan/view/recordsToScan/"
    response = requests.get(scan_status_url, params={"apikey": API_KEY})

    if response.status_code == 200:
        records_to_scan = int(response.json().get("recordsToScan", 0))
        print(f"[INFO] Enregistrements restants à analyser : {records_to_scan}")

        if records_to_scan == 0:
            print("[SUCCESS] Scan passif terminé !")
            break

        time.sleep(5)
    else:
        print(f"[ERROR] Erreur lors de la récupération de l'état du scan passif : {response.status_code} - {response.text}")
        break

# Étape 3 : Récupérer les alertes de sécurité détectées
alerts_url = f"{ZAP_URL}/JSON/core/view/alerts/"
alerts_response = requests.get(alerts_url, params={"apikey": API_KEY, "baseurl": TARGET_URL})

if alerts_response.status_code == 200:
    alerts = alerts_response.json().get("alerts", [])
    if alerts:
        print("\n🚨 Alertes détectées :")
        for alert in alerts:
            print(f"- {alert['alert']} | Sévérité : {alert['risk']} | URL : {alert['url']}")
    else:
        print("\n✅ Aucun problème détecté.")
else:
    print(f"[ERROR] Erreur lors de la récupération des alertes : {alerts_response.text}")

print("🎯 Scan terminé avec succès !")
