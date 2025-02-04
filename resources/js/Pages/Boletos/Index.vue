<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['boletos', 'clientes']);

const showingModal = ref(false);
const isEditing = ref(false);

const form = useForm({
    cliente_id: '',
    nome_devedor: '',
    data_vencimento: '',
    titulo_numero: '',
    valor: '',
    juro: ''
});

const openModal = (boleto = null) => {
    if (boleto) {
        form.cliente_id = boleto.cliente_id;
        form.nome_devedor = boleto.nome_devedor;
        form.data_vencimento = boleto.data_vencimento;
        form.titulo_numero = boleto.titulo_numero;
        form.valor = boleto.valor;
        form.juro = boleto.juro;
        form.id = boleto.id;
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
        form.put(route('boletos.update', form.id), {
            onSuccess: () => closeModal(),
        });
    } else {
        form.post(route('boletos.store'), {
            onSuccess: () => closeModal(),
        });
    }
};
</script>

<template>
    <Head title="Boletos"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Boletos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between mb-6">
                            <h3 class="text-lg font-medium">Lista de Boletos</h3>
                            <PrimaryButton @click="openModal()">
                                Novo Boleto
                            </PrimaryButton>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 text-left">Cliente</th>
                                <th class="px-6 py-3 text-left">Nome Devedor</th>
                                <th class="px-6 py-3 text-left">Data de Vencimento</th>
                                <th class="px-6 py-3 text-left">Título N.</th>
                                <th class="px-6 py-3 text-left">Valor</th>
                                <th class="px-6 py-3 text-left">Juro</th>
                                <th class="px-6 py-3 text-center">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="boleto in boletos" :key="boleto.id">
                                <td class="px-6 py-4">{{ boleto.cliente.nome }}</td>
                                <td class="px-6 py-4">{{ boleto.nome_devedor }}</td>
                                <td class="px-6 py-4">{{ boleto.data_vencimento }}</td>
                                <td class="px-6 py-4">{{ boleto.titulo_numero }}</td>
                                <td class="px-6 py-4">{{ boleto.valor }}</td>
                                <td class="px-6 py-4">{{ boleto.juro }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button
                                        @click="openModal(boleto)"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3"
                                    >
                                        Editar
                                    </button>
                                    <button
                                        @click="form.delete(route('boletos.destroy', boleto.id))"
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
                                >&times;
                                </button>
                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ isEditing ? 'Editar Boleto' : 'Novo Boleto' }}
                                </h2>

                                <form @submit.prevent="submit" class="mt-6">
                                    <div class="mb-6">
                                        <InputLabel for="cliente_id" value="Cliente"/>
                                        <select
                                            id="cliente_id"
                                            class="mt-1 block w-full"
                                            v-model="form.cliente_id"
                                            required
                                        >
                                            <option value="" disabled>Selecione um cliente</option>
                                            <option
                                                v-for="cliente in clientes"
                                                :key="cliente.id"
                                                :value="cliente.id"
                                            >
                                                {{ cliente.nome }}
                                            </option>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors.cliente_id"/>
                                    </div>

                                    <div class="mb-6">
                                        <InputLabel for="nome_devedor" value="Nome Devedor"/>
                                        <TextInput
                                            id="nome_devedor"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.nome_devedor"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.nome_devedor"/>
                                    </div>

                                    <div class="mb-6">
                                        <InputLabel for="data_vencimento" value="Data de Vencimento"/>
                                        <TextInput
                                            id="data_vencimento"
                                            type="date"
                                            class="mt-1 block w-full"
                                            v-model="form.data_vencimento"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.data_vencimento"/>
                                    </div>

                                    <div class="mb-6">
                                        <InputLabel for="titulo_numero" value="Título N."/>
                                        <TextInput
                                            id="titulo_numero"
                                            type="text"
                                            class="mt-1 block w-full"
                                            v-model="form.titulo_numero"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.titulo_numero"/>
                                    </div>

                                    <div class="mb-6">
                                        <InputLabel for="valor" value="Valor"/>
                                        <TextInput
                                            id="valor"
                                            type="number"
                                            step="0.01"
                                            class="mt-1 block w-full"
                                            v-model="form.valor"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.valor"/>
                                    </div>

                                    <div class="mb-6">
                                        <InputLabel for="juro" value="Juro"/>
                                        <TextInput
                                            id="juro"
                                            type="number"
                                            step="0.01"
                                            class="mt-1 block w-full"
                                            v-model="form.juro"
                                            required
                                        />
                                        <InputError class="mt-2" :message="form.errors.juro"/>
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
