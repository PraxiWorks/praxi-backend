<?php

namespace Database\Seeders\Permissions;

class SchedulingPermissionsSeeder extends BasePermissionsSeeder
{
    protected function getModuleName(): string
    {
        return 'Scheduling';
    }

    protected function getPermissions(): array
    {
        return [
            ['display_name' => 'Listar Configurações de Agendamento', 'name' => 'scheduling.scheduleSettings.list'],
            ['display_name' => 'Criar Configuração de Agendamento', 'name' => 'scheduling.scheduleSettings.store'],
            ['display_name' => 'Mostrar Configuração de Agendamento', 'name' => 'scheduling.scheduleSettings.show'],
            ['display_name' => 'Atualizar Configuração de Agendamento', 'name' => 'scheduling.scheduleSettings.update'],
            ['display_name' => 'Deletar Configuração de Agendamento', 'name' => 'scheduling.scheduleSettings.delete'],

            ['display_name' => 'Listar Eventos', 'name' => 'scheduling.event.list'],
            ['display_name' => 'Criar Evento', 'name' => 'scheduling.event.store'],
            ['display_name' => 'Mostrar Evento', 'name' => 'scheduling.event.show'],
            ['display_name' => 'Atualizar Evento', 'name' => 'scheduling.event.update'],
            ['display_name' => 'Deletar Evento', 'name' => 'scheduling.event.delete'],

            ['display_name' => 'Listar Procedimentos de Evento', 'name' => 'scheduling.eventProcedure.list'],
            ['display_name' => 'Criar Procedimento de Evento', 'name' => 'scheduling.eventProcedure.store'],
            ['display_name' => 'Mostrar Procedimento de Evento', 'name' => 'scheduling.eventProcedure.show'],
            ['display_name' => 'Atualizar Procedimento de Evento', 'name' => 'scheduling.eventProcedure.update'],
            ['display_name' => 'Deletar Procedimento de Evento', 'name' => 'scheduling.eventProcedure.delete'],

            ['display_name' => 'Listar Clientes', 'name' => 'scheduling.client.list'],
            ['display_name' => 'Criar Cliente', 'name' => 'scheduling.client.store'],
            ['display_name' => 'Mostrar Cliente', 'name' => 'scheduling.client.show'],
            ['display_name' => 'Atualizar Cliente', 'name' => 'scheduling.client.update'],
            ['display_name' => 'Deletar Cliente', 'name' => 'scheduling.client.delete'],

            ['display_name' => 'Listar Endereços de Cliente', 'name' => 'scheduling.clientAddress.list'],
            ['display_name' => 'Criar Endereço de Cliente', 'name' => 'scheduling.clientAddress.store'],
            ['display_name' => 'Mostrar Endereço de Cliente', 'name' => 'scheduling.clientAddress.show'],
            ['display_name' => 'Atualizar Endereço de Cliente', 'name' => 'scheduling.clientAddress.update'],
            ['display_name' => 'Deletar Endereço de Cliente', 'name' => 'scheduling.clientAddress.delete']
        ];
    }
}
