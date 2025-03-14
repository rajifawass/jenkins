pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/rajifawass/jenkins.git'
            }
        }

        stage('Setup Environment') {
            steps {
                bat '"C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" -m venv venv'
            }
        }
 
        stage('Install Dependencies') {
            steps {
                bat 'composer install'
            }
        }

        
        stage('Static Code Analysis') {
            steps {
                script {
                    def exitCode = bat(returnStatus: true, script: '''
                        vendor\bin\phpstan analyse --level=max src/ --no-progress --error-format=table --memory-limit=2G
                    ''')
                    if (exitCode != 0) {
                        echo "PHPStan a trouvé des erreurs, mais on continue l'exécution du pipeline."
                    }
                }
            }
        }
        

        stage('SQL Injection Test (Automatisation)') {
            steps {
                bat '"C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" test\\automatisation_sqlmap.py'
            }
        }

        
        stage('Run spider') {
            steps {
                bat '"C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" test\\spider_scan.py'
            }
        }

        stage('Run Scan_active') {
            steps {
                bat '"C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" test\\active_scan.py'
            }
        }

        stage('Passive Scan') {
            steps {
                bat '"C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" test\\passive_scan.py'
            }
        }


        // stage('Run form_authentication') {
        //     steps {
        //         bat '"C:\\Users\\user\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\form_autentification.py'
        //     }
        // }
        

    }

    post {
        always {
            echo "Pipeline terminé"
        }
    }
}