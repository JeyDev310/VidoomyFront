<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('bdmFront')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/home/ec2-user/deploy')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:skeletorsmith/bdmFront')
            // the repository branch to deploy
            ->repositoryBranch('master')
            ->sharedFilesAndDirs(['.env'])
        ;
    }

    // run some local or remote commands before the deployment is started
    public function beforeStartingDeploy()
    {
        // $this->runLocal('./vendor/bin/simple-phpunit');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
        $this->runLocal('scp config/secrets/prod/prod.decrypt.private.php bdmFront:/home/ec2-user/deploy/current/config/secrets/prod');
    }
};
