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
                    // Copy files containing sensitive data from the secure location to ensure that sensitive information is not exposed in the Git repository
                    sh 'sudo cp /var/secure_data/follow_me/docker-compose.yml ${WORKSPACE}/docker-compose.yml'
                    sh 'sudo cp /var/secure_data/follow_me/.env ${WORKSPACE}/src/.env'

                    // Navigate to the workspace directory
                    //sh 'cd ${WORKSPACE}'

                    // Run the Docker containers
                    //sh 'sudo docker compose up -d'

                    // Navigate to the workspace directory and run the docker containers
                    dir("${WORKSPACE}") {
                        sh 'sudo docker compose up -d'
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
