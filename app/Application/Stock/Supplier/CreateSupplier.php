<?php

namespace App\Application\Stock\Supplier;

use App\Application\Stock\Supplier\DTO\CreateSupplierRequestDTO;
use App\Domain\Exceptions\Core\Company\CompanyException;
use App\Domain\Exceptions\Stock\Supplier\SupplierException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;
use App\Models\Stock\Supplier;
use App\Services\Image\ProcessImage;

class CreateSupplier
{

    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private SupplierRepositoryInterface $supplierRepositoryInterface,
        private ProcessImage $processImage
    ) {}

    public function execute(CreateSupplierRequestDTO $input): bool
    {
        $this->validateInput($input);

        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        if (empty($company)) {
            throw new CompanyException('Empresa não encontrada', 400);
        }

        if(!empty($this->supplierRepositoryInterface->getByCnpjNumber($input->getCnpjNumber()))){
            throw new SupplierException('Fornecedor já cadastrado', 400);
        }

        $pathImage = $this->processImage->execute($input->getImageBase64(), 'suppliers', $company->name, $input->getName());

        $supplier = Supplier::new(
            $input->getCompanyId(),
            $input->getName(),
            $input->getPhoneNumber(),
            $input->getCnpjNumber(),
            $pathImage,
            $input->getStatus()
        );

        if (!$this->supplierRepositoryInterface->save($supplier)) {
            throw new SupplierException('Erro ao salvar o fornecedor', 500);
        }

        return true;
    }

    private function validateInput(CreateSupplierRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new SupplierException('Nome não informado', 400);
        }

        if(empty($input->getPhoneNumber())){
            throw new SupplierException('Telefone não informado', 400);
        }

        if(empty($input->getCnpjNumber())){
            throw new SupplierException('CNPJ não informado', 400);
        }
    }
}
