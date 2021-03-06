<?php
/**
 * @copyright 2012,2013 Binovo it Human Project, S.L.
 * @license http://www.opensource.org/licenses/bsd-license.php New-BSD
 */

namespace App\Command;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Console\Command\Command;

class CreateAdminUserCommand extends ContainerAwareCommand
{
    private $encoderFactory;
    /**
     * {@inheritDoc}
     * @see \Symfony\Component\Console\Command\Command::__construct()
     */
    public function __construct(EncoderFactoryInterface $encoder)
    {
        $this->encoderFactory = $encoder;
        parent::__construct();
    }
    
    protected function configure()
    {
        parent::configure();
        $this->setName('elkarbackup:create_admin')
             ->addOption('reset', null, InputOption::VALUE_NONE, 'Reset the root account to the original values')
             ->setDescription('Creates initial admin user');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (0 != posix_geteuid()) {
            echo "You have to be root to run this command\n";

            return 1;
        }
        $container = $this->getContainer();
        $doctrine = $container->get('doctrine');
        $em = $doctrine->getManager();
        $user = $doctrine->getRepository('App:User')->find(User::SUPERUSER_ID);
        if (!$user) {
            $user = new User();
        } else if ($input->getOption('reset')) {
            echo "Admin user exists. Trying to reset to initial values.\n";
        } else {
            echo "Admin user exists and reset was not requested. Nothing to do.\n";

            return 0;
        }
        $factory = $this->encoderFactory;
        $encoder = $factory->getEncoder($user);
        $user->setUsername('root');
        $user->setEmail('root@localhost');
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setSalt(md5(uniqid(null, true)));
        $password = $encoder->encodePassword('root', $user->getSalt());
        $user->setPassword($password);
        $em->persist($user);
        $em->flush();

        return 0;
    }
}