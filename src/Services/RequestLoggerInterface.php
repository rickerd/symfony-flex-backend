<?php
declare(strict_types=1);
/**
 * /src/Services/RequestLoggerInterface.php
 *
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
namespace App\Services;

use App\Resource\RequestLogResource;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface RequestLoggerInterface
 *
 * @package App\Services\Interfaces
 * @author  TLe, Tarmo Leppänen <tarmo.leppanen@protacon.com>
 */
interface RequestLoggerInterface
{
    /**
     * ResponseLogger constructor.
     *
     * @param LoggerInterface    $logger
     * @param RequestLogResource $resource
     */
    public function __construct(LoggerInterface $logger, RequestLogResource $resource);

    /**
     * Setter for response object.
     *
     * @param Response $response
     *
     * @return RequestLoggerInterface
     */
    public function setResponse(Response $response): RequestLoggerInterface;

    /**
     * Setter for request object.
     *
     * @param Request $request
     *
     * @return RequestLoggerInterface
     */
    public function setRequest(Request $request): RequestLoggerInterface;

    /**
     * Setter method for current user.
     *
     * @param UserInterface|null $user
     *
     * @return RequestLoggerInterface
     */
    public function setUser(UserInterface $user = null): RequestLoggerInterface;

    /**
     * Setter method for 'master request' info.
     *
     * @param bool $masterRequest
     *
     * @return RequestLoggerInterface
     */
    public function setMasterRequest(bool $masterRequest): RequestLoggerInterface;

    /**
     * Method to handle current response and log it to database.
     *
     * @throws \Exception
     */
    public function handle(): void;
}