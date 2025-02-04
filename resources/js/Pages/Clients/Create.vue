<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    nome: '',
    cnpj: ''
});

const submit = () => {
    form.post(route('clientes.store'));
};
</script>

<template>
    <Head title="Novo Cliente" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Novo Cliente
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Informações do Cliente</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Cadastre as informações do novo cliente.
                            </p>
                        </header>

                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div class="flex gap-6">
                                <div class="flex-1">
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

                                <div class="flex-1">
                                    <InputLabel for="cnpj" value="CNPJ" />
                                    <TextInput
                                        id="cnpj"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.cnpj"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.cnpj" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Salvar</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Salvo.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
