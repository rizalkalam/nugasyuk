pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Use the 'checkout' step to pull the Git repository
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/main']], // Specify the branch you want to pull
                    userRemoteConfigs: [[url: 'https://github.com/rizalkalam/nugasyuk.git']],
                ])
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
            }
        }

        stage('Database Migrations') {
            steps {
                sh 'php artisan migrate --force'
            }
        }

        stage('Deploy') {
            steps {
                // Copy your application to the web server directory
                sh 'rsync -avz --exclude=".env" . /var/www/html'
                // Restart the web server (e.g., Nginx)
                sh 'systemctl restart nginx'
            }
        }

        // Add more stages for building, testing, and deploying your project
    }
}