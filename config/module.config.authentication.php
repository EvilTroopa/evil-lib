<?php

namespace EvilLib;

return array(
    'storage' => array(
        'namespace' => 'EvilLib',
        'member' => 'User',
    ),
    'adapter' => array(
        'object_manager' => 'Doctrine\ORM\EntityManager',
        'object_repository' => '\EvilLib\Repository\AbstractEntityRepository',
        'identity_class' => '\EvilLib\Entity\AbstractUserEntity',
        'identity_property' => 'userEmail',
        'credential_property' => 'userPassword',
        'credential_callable' => array('\EvilLib\Service\UserService', 'checkUserPassword'),
    ),
);
