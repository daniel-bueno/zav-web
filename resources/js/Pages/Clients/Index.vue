<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { CNPJ_MASK } from '@/core/validators/documents/cnpj.validator';

const props = defineProps(['clientes']);

const showingModal = ref(false);
const isEditing = ref(false);

const form = useForm({
    nome: '',
    cnpj: ''
});

const openModal = (cliente = null) => {
    if (cliente) {
        form.nome = cliente.nome;
        form.cnpj = cliente.cnpj;
        form.id = cliente.id;
        isEditing.value = true;
    } else {
        form.reset();
        isEditing.value = false;
    }
    showingModal.value = true;
};

const closeModal = () => {
    showingModal.value = false;
    form.reset();
    isEditing.value = false;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('clientes.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('clientes.store'), {
            onSuccess: () => closeModal(),
        });
    }
};
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
                            <PrimaryButton @click="openModal()">
                                Novo Cliente
                            </PrimaryButton>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left">Nome</th>
                                    <th class="px-6 py-3 text-left">CNPJ</th>
                                    <th class="px-6 py-3 text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="cliente in clientes" :key="cliente.id">
                                    <td class="px-6 py-4">{{ cliente.nome }}</td>
                                    <td class="px-6 py-4">{{ cliente.cnpj }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button
                                            @click="openModal(cliente)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            @click="form.delete(route('clientes.destroy', cliente.id))"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Modal -->
                        <Modal :show="showingModal" @close="closeModal">
                            <div class="p-6">
                                <button
                                    @click="closeModal"
                                    class="absolute top-4 right-4 text-black text-3xl"
                                >&times;</button>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ isEditing ? 'Editar Cliente' : 'Novo Cliente' }}
                                </h2>

                                <form @submit.prevent="submit" class="mt-6">
                                    <div class="mb-6">
                                        <InputLabel for="nome" value="Nome" />
                                        <TextInput
                                            id="nome"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.nome"
                                            required
                                            autofocus
                                        />
                                        <InputError class="mt-2" :message="form.errors.nome" />
                                    </div>

                                    <div class="mb-6">
                                        <InputLabel for="cnpj" value="CNPJ" />
                                        <TextInput
                                            id="cnpj"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.cnpj"
                                            v-maska="CNPJ_MASK"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.cnpj" />
                                    </div>

                                    <div class="flex justify-end">
                                        <PrimaryButton
                                            class="ml-4"
                                            :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing"
                                        >
                                            {{ isEditing ? 'Salvar' : 'Criar' }}
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
