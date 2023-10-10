pipeline {
    agent any

    stages {
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
    }
}
