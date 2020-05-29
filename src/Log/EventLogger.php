<?php

namespace RestTest\Laravel\Log;

use ReflectionClass;
use Psr\Log\LoggerInterface;
use RestTest\Laravel\Models\Events\Event as ModelEvent;
use RestTest\Laravel\Query\Events\QueryExecuted as QueryEvent;

class EventLogger
{
    /**
     * The logger instance.
     *
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * Logs the given event.
     *
     * @param mixed $event
     */
    public function log($event)
    {
        if ($event instanceof ModelEvent) {
            $this->model($event);
        } elseif ($event instanceof QueryEvent) {
            $this->query($event);
        }
    }

    /**
     * Logs a model event.
     *
     * @param ModelEvent $event
     *
     * @return void
     */
    public function model(ModelEvent $event)
    {
        if (isset($this->logger)) {
            $model = $event->getModel();

            $on = get_class($model);

            $connection = $model->getConnection()->getLdapConnection();

            $message = "EventSentry ({$connection->getHost()})"
                ." - Operation: {$this->getOperationName($event)}";

            $this->logger->info($message);
        }
    }

    /**
     * Logs a query event.
     *
     * @param QueryEvent $event
     *
     * @return void
     */
    public function query(QueryEvent $event)
    {
        if (isset($this->logger)) {
            $query = $event->getQuery();

            $connection = $query->getConnection()->getLdapConnection();

            $selected = implode(',', $query->getSelects());

            $message = "EventSentry ({$connection->getHost()})"
                ." - Operation: {$this->getOperationName($event)}"
                ." - Time Elapsed: {$event->getTime()}";

            $this->logger->info($message);
        }
    }

    /**
     * Returns the operational name of the given event.
     *
     * @param mixed $event
     *
     * @return string
     */
    protected function getOperationName($event)
    {
        return (new ReflectionClass($event))->getShortName();
    }
}