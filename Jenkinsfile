pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Ambil kode dari repository Git
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                // Install Composer dan dependensinya
                sh 'composer install --ignore-platform-req=ext-curl'
            }
        }

        stage('Build and Deploy') {
            steps {
                // Lakukan proses build, migrasi, dll.
                sh 'php artisan key:generate'
                sh 'php artisan config:cache'
                sh 'php artisan migrate --force'
            }
        }

        stage('Configure Nginx') {
            steps {
                // Konfigurasi Nginx untuk mengarahkan ke direktori aplikasi
                sh 'sudo cp index.php /etc/nginx/sites-available/nugasyuk'
                sh 'sudo ln -s /etc/nginx/sites-available/nugasyuk /etc/nginx/sites-enabled/'
                sh 'sudo systemctl reload nginx'
            }
        }
    }
}
