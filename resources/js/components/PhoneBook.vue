<template>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-header m-4">
                <h1 class="card-title text-center m-4">Phone Book</h1>
            </div>
            <div class="card-body">
                <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ errorMessage }}
                    <button type="button" class="btn-close" @click="errorMessage = ''" aria-label="Close"></button>
                </div>
                <AddContact @contact-added="triggerUpdate" @error="setError" />
                <ListContacts :refresh-key="refreshKey" @error="setError" />
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
