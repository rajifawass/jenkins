import os
import subprocess

def check_sqlmap_installed():
    """Vérifie si sqlmap est installé."""
    try:
        subprocess.run(["sqlmap", "--version"], check=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
        print("[OK] sqlmap est installé.")
        return True
    except FileNotFoundError:
        print("[ERREUR] sqlmap n'est pas installé. Installez-le avec 'pip install sqlmap'.")
        return False

