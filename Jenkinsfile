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
In this example:

agent any specifies that the pipeline can run on any available Jenkins agent.
Inside the Checkout stage, we use the checkout step.
In the userRemoteConfigs section, replace 'https://github.com/rizalkalam/nugasyuk.git' with the URL of your Git repository.
You can specify the branch you want to pull in the branches section (e.g., '*/main' for the main branch).
Once you've defined your pipeline with the checkout step, you can configure the pipeline in Jenkins, and it will automatically pull the specified Git repository before executing subsequent stages of your pipeline, such as building and deploying your project.





