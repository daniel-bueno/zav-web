<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps(['clientes']);
</script>

<template>
    <Head title="Clientes" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-6">
                            <h3 class="text-lg font-medium">Lista de Clientes</h3>
                            <Link :href="route('clientes.create')">
                                <PrimaryButton>
                                    Novo Cliente
                                </PrimaryButton>
                            </Link>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 text-left">Nome</th>
                                <th class="px-6 py-3 text-left">CNPJ</th>
                                <th class="px-6 py-3 text-right">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="cliente in clientes" :key="cliente.id">
                                <td class="px-6 py-4">{{ cliente.nome }}</td>
                                <td class="px-6 py-4">{{ cliente.cnpj }}</td>
                                <td class="px-6 py-4 text-right">
                                    <Link
                                        :href="route('clientes.edit', cliente.id)"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3"
                                    >
                                        Editar
                                    </Link>
                                    <Link
                                        :href="route('clientes.destroy', cliente.id)"
                                        method="delete"
                                        as="button"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Excluir
                                    </Link>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
