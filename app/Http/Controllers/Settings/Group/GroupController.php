<?php

namespace App\Http\Controllers\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\Group\CreateGroup;
use App\Application\Settings\Group\DeleteGroup;
use App\Application\Settings\Group\DTO\AssignPermissionsToGroupRequestDTO;
use App\Application\Settings\Group\DTO\CreateGroupRequestDTO;
use App\Application\Settings\Group\DTO\ListGroupRequestDTO;
use App\Application\Settings\Group\DTO\UpdateGroupRequestDTO;
use App\Application\Settings\Group\ListGroup;
use App\Application\Settings\Group\ShowGroup;
use App\Application\Settings\Group\UpdateGroup;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function __construct(
        private CreateGroup $createGroupUseCase,
        private ShowGroup $showGroupUseCase,
        private ListGroup $listGroupUseCase,
        private UpdateGroup $updateGroupUseCase,
        private DeleteGroup $deleteGroupUseCase
    ) {}

    public function index(Request $request)
    {
        $companyId = $request->route('companyId');
        $status = $request->status ?? '';

        try {
            $input = new ListGroupRequestDTO(
                $companyId,
                $status
            );
            $output = $this->listGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $status = $request->status ?? false;

        try {
            $input = new CreateGroupRequestDTO(
                $companyId,
                $name,
                $status
            );
            $output = $this->createGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->route('groupId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }


    public function update(Request $request)
    {
        $id = $request->route('groupId') ?? 0;
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $status = $request->status ?? false;

        try {
            $input = new UpdateGroupRequestDTO(
                $id,
                $companyId,
                $name,
                $status
            );
            $output = $this->updateGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->route('groupId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteGroupUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
