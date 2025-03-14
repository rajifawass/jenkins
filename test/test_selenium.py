from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.action_chains import ActionChains
import time

# Configurer le WebDriver
options = webdriver.ChromeOptions()
options.add_experimental_option("detach", True)  # Garde le navigateur ouvert

driver = webdriver.Chrome(options=options)
driver.get("http://localhost/salon/inscription.php")  # Page d'inscription

wait = WebDriverWait(driver, 10)

# Attendre que le formulaire soit visible
wait.until(EC.presence_of_element_located((By.TAG_NAME, "form")))

# Vérifier le nombre de boutons
buttons = driver.find_elements(By.TAG_NAME, "button")
print(f"Nombre de boutons trouvés: {len(buttons)}")

# Vérifier si au moins un bouton est présent
if len(buttons) == 0:
    print("❌ Aucun bouton trouvé. Vérifiez votre HTML.")
    driver.quit()
    exit()

# Sélectionner un bouton avec un sélecteur CSS plus précis
try:
    button = wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "button[type=submit]")))
except:
    print("❌ Timeout: Bouton introuvable ou non cliquable.")
    driver.quit()
    exit()

# Vérifier si le bouton est visible et activé
if button.is_displayed():
    print("✅ Le bouton est visible")
else:
    print("❌ Le bouton est masqué")

if button.is_enabled():
    print("✅ Le bouton est activé")
else:
    print("❌ Le bouton est désactivé")

# Forcer le clic avec ActionChains
ActionChains(driver).move_to_element(button).click().perform()

print("✅ Clic effectué avec succès")

time.sleep(3)

driver.quit()
