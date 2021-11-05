<?php

namespace SaaSFormation\Vendor\CommandStore;

use SaaSFormation\Vendor\CommandBus\Command;
use StraTDeS\VO\Single\Id;

interface CommandStoreInterface
{
    public function create(Command $command): void;

    public function byId(Id $id): Command;
}
