<?php

namespace App\Application\Register\Client\DTO;

class ListClientRequestDTO
{
    public function __construct(
        private int $companyId,
        private ?bool $status,
        private ?string $searchQuery,
        private int $page,
        private int $perPage
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function getSearchQuery(): ?string
    {
        return $this->searchQuery;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
