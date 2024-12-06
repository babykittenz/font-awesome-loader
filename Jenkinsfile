pipeline {
  agent {
    kubernetes {
      defaultContainer 'node'
      yaml """
kind: Pod
spec:
  securityContext:
    runAsUser: 1000
    runAsGroup: 1000
    fsGroup: 1000
  serviceAccountName: jenkins-agent
  containers:
  - name: node
    image: 402982583524.dkr.ecr.us-east-1.amazonaws.com/tux-wp-child:latest
    imagePullPolicy: Always
    tty: true
    command:
    - cat
    resources:
      limits:
        cpu: "512m"
        memory: "1G"
      requests:
        cpu: "100m"
        memory: "256M"
"""
    }
  }
  parameters {
    string(name: 'GithubCommitHash', defaultValue: '', description: 'Github hash for a specific commit to build from.')
  }
  environment {
    GIT_AUTHOR_NAME = "kurtrank"
    GIT_AUTHOR_EMAIL = "kurtrank@gmail.com"
    GIT_COMMITTER_NAME = "kurtrank"
    GIT_COMMITTER_EMAIL = "kurtrank@gmail.com"
    GIT_COMMIT_HASH = "${params.GithubCommitHash}"
    IS_CI = "true"
  }

  stages {
    stage('Build Plugin Release') {
      steps {
        script {
          if (env.BRANCH_NAME == 'main' || env.BRANCH_NAME == 'master' || env.BRANCH_NAME == 'beta') { 
            container('node') {
              withCredentials([
                usernamePassword(credentialsId: 'wiley_github_token', usernameVariable: '', passwordVariable: 'GITHUB_TOKEN'),
                string(credentialsId: 'fontawesome_npm_token', variable: 'FONTAWESOME_NPM_TOKEN')
              ]) {
                sh '''export HOME=$WORKSPACE
                  git config --global url."https://$GITHUB_TOKEN@github.com/".insteadOf ssh://git@github.com/
                  if [ "$GIT_COMMIT_HASH" != "" ]; then git checkout $GIT_COMMIT_HASH; fi
                  npm config set "@fortawesome:registry" https://npm.fontawesome.com/
                  npm config set "//npm.fontawesome.com/:_authToken" $FONTAWESOME_NPM_TOKEN
                  npm ci
                  npm run build
                  npx semantic-release'''
              }
            }
          }
        }
      }
    }
  }
}
