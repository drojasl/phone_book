<template>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header mt-5 custom-container">
                <h1 class="card-title text-center m-4">Phone Book</h1>
            </div>
            <div class="card-body">
                <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ errorMessage }}
                </div>
                <div class="custom-container m-2">
                    <AddContact @contact-added="triggerUpdate" @error="setError" />
                </div>
                <div class="custom-container m-2">
                    <ListContacts :refresh-key="refreshKey" @error="setError" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import AddContact from './AddContact.vue';
    import ListContacts from './ListContacts.vue';

    const refreshKey = ref(0);
    const errorMessage = ref('');

    const triggerUpdate = () => {
        refreshKey.value += 1;
    };

    const setError = (error) => {
        errorMessage.value = error;
    };
</script>
