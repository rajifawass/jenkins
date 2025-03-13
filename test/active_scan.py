import requests
import time

# Configuration
ZAP_URL = "http://localhost:8081"
TARGET_URL = "http://localhost/salon/index.php"  # URL cible
API_KEY = "87n4jl3pqa2c9l119a3vt11ktt"  # Mets la bonne clé API

# Fonction pour vérifier le statut du scan
def get_scan_status(scan_id):
    status_url = f"{ZAP_URL}/JSON/ascan/view/status/?apikey={API_KEY}&scanId={scan_id}"
    response = requests.get(status_url)
    if response.status_code == 200:
        return response.json().get("status", "0")
    return "0"

# Étape 1 : Démarrer le scan actif
scan_url = f"{ZAP_URL}/JSON/ascan/action/scan/?apikey={API_KEY}&url={TARGET_URL}&recurse=true"
scan_response = requests.get(scan_url)

if scan_response.status_code == 200:
    scan_id = scan_response.json().get("scan", "")
    print(f"⚡ Scan actif lancé avec succès ! (ID : {scan_id})")
else:
    print(f"❌ Erreur lors du lancement du scan actif : {scan_response.text}")
    exit(1)

# Suivi du scan actif
while True:
    status = get_scan_status(scan_id)
    print(f"📊 Progression du scan actif : {status}%")
    if status == "100":
        break
    time.sleep(5)

print("✅ Scan actif terminé !")

# Étape 2 : Récupérer les alertes trouvées
alerts_url = f"{ZAP_URL}/JSON/core/view/alerts/?apikey={API_KEY}&baseurl={TARGET_URL}"
alerts_response = requests.get(alerts_url)

if alerts_response.status_code == 200:
    alerts = alerts_response.json().get("alerts", [])
    if alerts:
        print("\n🚨 Alertes trouvées :")
        for alert in alerts:
            print(f"- {alert['alert']} | Sévérité : {alert['risk']} | URL : {alert['url']}")
    else:
        print("\n✅ Aucun problème détecté.")
else:
    print(f"❌ Erreur lors de la récupération des alertes : {alerts_response.text}")

print("🎯 Scan terminé avec succès !")
