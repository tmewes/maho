<?php

namespace MahoCLI\Commands;

use Mage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'admin:user:change-password',
    description: 'List all admin users'
)]
class AdminUserChangepassword extends BaseMahoCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initMaho();

        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $question = new Question('username: ', '');
        $username = $questionHelper->ask($input, $output, $question);
        $username = trim($username);
        if (!strlen($username)) {
            $output->writeln('<error>Username cannot be empty</error>');
            return Command::INVALID;
        }

        $question = new Question('new password: ', '');
        $password = $questionHelper->ask($input, $output, $question);
        $password = trim($password);
        if (!strlen($password)) {
            $output->writeln('<error>New password cannot be empty</error>');
            return Command::INVALID;
        }

        $user = Mage::getModel('admin/user')
            ->loadByUsername($username);
        if (!$user->getUserId()) {
            $output->writeln('<error>User not found</error>');
            return Command::FAILURE;
        }

        $user->setNewPassword($password);
        $user->save();
        $output->writeln("<info>Password changed for user {$username}</info>");

        return Command::SUCCESS;
    }
}
