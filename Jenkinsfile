pipeline {
    agent any

    environment {
        GITHUB_REPO = 'https://github.com/nebojsatasic/follow-me.git'
        DEPLOY_DIR = '/var/www'
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    // Clone or pull from GitHub repository
                    git url: "${GITHUB_REPO}", credentialsId: '', branch: 'main'
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    // Copy file containing sensitive data from the secure location to ensure that sensitive information is not exposed in the Git repository
                    sh 'sudo cp /var/secure_data/follow_me/.env ${WORKSPACE}/src/.env'

                    // Navigate to the workspace directory and run the docker containers
                    dir("${WORKSPACE}") {
                        sh 'sudo docker compose up -d --build'
                    }
                }
            }
        }
    }

    post {
        always {
            echo 'Deployment complete.'
        }
    }
}
