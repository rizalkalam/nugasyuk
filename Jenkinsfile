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

        // Add more stages for building, testing, and deploying your project
    }
}