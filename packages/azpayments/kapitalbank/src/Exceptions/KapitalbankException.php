<?php

namespace AZPayments\Kapitalbank\Exceptions;

use Exception;

class KapitalbankException extends Exception
{
    protected string $errorCode;
    protected array $errorDetails;

    public function __construct(
        string $message = '',
        string $errorCode = 'UNKNOWN',
        array $errorDetails = [],
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->errorDetails = $errorDetails;
    }

    /**
     * Xəta kodunu al
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    /**
     * Xəta detallarını al
     */
    public function getErrorDetails(): array
    {
        return $this->errorDetails;
    }

    /**
     * Decline səbəbini al
     */
    public function getDeclineReason(): ?string
    {
        return $this->errorDetails['declineReason'] ?? null;
    }

    /**
     * PMO nəticə kodunu al
     */
    public function getPmoResultCode(): ?string
    {
        return $this->errorDetails['pmoResultCode'] ?? null;
    }

    /**
     * PMO decline təsvirini al
     */
    public function getPmoDeclineDesc(): ?string
    {
        return $this->errorDetails['pmoDeclineDesc'] ?? null;
    }

    /**
     * Xətanın array forması
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'error_code' => $this->errorCode,
            'error_details' => $this->errorDetails,
            'decline_reason' => $this->getDeclineReason(),
            'pmo_result_code' => $this->getPmoResultCode(),
            'pmo_decline_desc' => $this->getPmoDeclineDesc(),
        ];
    }
}