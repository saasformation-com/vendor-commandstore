<?php

namespace SaaSFormation\Vendor\CommandStore;

use SaaSFormation\Vendor\CommandBus\Command;
use StraTDeS\VO\Single\Id;

class MySQLCommandStore implements CommandStoreInterface
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws PDOException
     */
    public function create(Command $command): void
    {
        $stmt = $this->connection->prepare("INSERT INTO command_store (id, code, version, data, created_at) VALUES (UNHEX(:id), :code, :version, :data, :created_at)");

        $stmt->bindValue(':id', str_replace('-', '', $command->id()->getHumanReadableId()));
        $stmt->bindValue(':code', $command->code());
        $stmt->bindValue(':version', $command->version(), \PDO::PARAM_INT);
        $stmt->bindValue(':data', json_encode($command->toArray()));
        $stmt->bindValue(':created_at', (new \DateTime())->format('Y-m-d H:i:s.u'));

        if (!$stmt->execute()) {
            throw new PDOException($this->connection->errorCode());
        }
    }

    public function byId(Id $id): Command
    {
        // TODO: Implement byId() method.
    }
}
