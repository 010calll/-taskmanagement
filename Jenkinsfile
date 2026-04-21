pipeline {
    agent any

    triggers {
        githubPush()
    }

    environment {
        APP_URL = 'http://localhost:1122'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Test PHP Syntax') {
            steps {
                sh '''
                    find . -name "*.php" -print0 | while IFS= read -r -d '' file; do
                      php -l "$file"
                    done
                '''
            }
        }

        stage('Validate Docker Compose') {
            steps {
                sh '''
                    if command -v docker-compose >/dev/null 2>&1; then
                      docker-compose config
                    else
                      docker compose config
                    fi
                '''
            }
        }

        stage('Build And Deploy') {
            steps {
                sh '''
                    if command -v docker-compose >/dev/null 2>&1; then
                      docker-compose down
                      docker-compose up --build -d
                    else
                      docker compose down
                      docker compose up --build -d
                    fi
                '''
            }
        }

        stage('Smoke Test') {
            steps {
                sh '''
                    sleep 10
                    curl --fail --silent "$APP_URL" >/dev/null
                '''
            }
        }

        stage('Check Containers') {
            steps {
                sh '''
                    if command -v docker-compose >/dev/null 2>&1; then
                      docker-compose ps
                    else
                      docker compose ps
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo "Deployment OK. Application available at ${APP_URL}"
        }
        failure {
            echo 'Pipeline failed: tests or deployment did not pass.'
        }
    }
}
