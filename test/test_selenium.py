from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import time

# Configurer le WebDriver
options = webdriver.ChromeOptions()
options.add_experimental_option("detach", True)  # Permet de garder le navigateur ouvert

driver = webdriver.Chrome(options=options)
driver.get("http://localhost/salon/inscription.php")  # URL de l'inscription

time.sleep(2)  # Attente pour le chargement de la page

# Données de test
login = "test_user123"
password = "password123"
nom = "Test"
prenom = "Utilisateur"
email = "test@example.com"
telephone = "0123456789"
datenaiss = "1990-01-01"
role = "Client"

# Remplir le formulaire d'inscription
driver.find_element(By.NAME, "login").send_keys(login)
driver.find_element(By.NAME, "password").send_keys(password)
driver.find_element(By.NAME, "nom").send_keys(nom)
driver.find_element(By.NAME, "prenom").send_keys(prenom)
driver.find_element(By.NAME, "email").send_keys(email)
driver.find_element(By.NAME, "telephone").send_keys(telephone)
driver.find_element(By.NAME, "datenaiss").send_keys(datenaiss)
driver.find_element(By.NAME, "role").send_keys(role)

driver.find_element(By.TAG_NAME, "button").click()  # Cliquer sur le bouton d'inscription

time.sleep(3)  # Attente pour la redirection

driver.get("http://localhost/salon/login.php")  # Aller à la page de connexion

time.sleep(2)

# Tester la connexion avec les mêmes identifiants
driver.find_element(By.NAME, "login").send_keys(login)
driver.find_element(By.NAME, "password").send_keys(password)
driver.find_element(By.NAME, "role").send_keys(role)
driver.find_element(By.TAG_NAME, "input[type=submit]").click()

time.sleep(3)

# Vérification : si la connexion réussit, l'utilisateur devrait être redirigé
if "admin.php" in driver.current_url:
    print("Test réussi : Connexion après inscription OK")
else:
    print("Test échoué : Problème de connexion après inscription")

driver.quit()
