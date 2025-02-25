<?php

namespace App\Application\Stock\Supplier;

use App\Application\Stock\Supplier\DTO\UpdateSupplierRequestDTO;
use App\Domain\Exceptions\Stock\Supplier\SupplierException;
use App\Domain\Exceptions\Stock\Supplier\SupplierNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;
use App\Services\Image\ProcessImage;

class UpdateSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepositoryInterface,
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(UpdateSupplierRequestDTO $input): bool
    {
        $this->validateInput($input);

        $supplier = $this->supplierRepositoryInterface->getById($input->getId());
        if (empty($supplier)) {
            throw new SupplierNotFoundException();
        }

        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        $pathImage = !empty($input->getImageBase64()) ? $this->processImage->execute($input->getImageBase64(), 'suppliers', $company->name, $supplier->path_image) : $supplier->path_image;

        $supplier->name = $input->getName();
        $supplier->phone_number = $input->getPhoneNumber();
        $supplier->cnpj_number = $input->getCnpjNumber();
        $supplier->path_image = $pathImage;
        $supplier->status = $input->getStatus();

        if (!$this->supplierRepositoryInterface->update($supplier)) {
            throw new SupplierException('Erro ao atualizar o fornecedor', 500);
        }

        return true;
    }

    private function validateInput(UpdateSupplierRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new SupplierException('Nome não informado', 400);
        }

        if (empty($input->getPhoneNumber())) {
            throw new SupplierException('Telefone não informado', 400);
        }

        if (empty($input->getCnpjNumber())) {
            throw new SupplierException('CNPJ não informado', 400);
        }
    }
}
