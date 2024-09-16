<template>
    <v-form @submit.prevent="addContactAction">
        <v-row>
            <v-col cols="12" md="4">
                <v-text-field v-model="name" label="Name" required></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-text-field v-model="phone" label="Phone Number" required></v-text-field>
            </v-col>
            <v-col cols="12" md="3">
                <v-btn type="submit" color="primary" block>Add Contact</v-btn>
            </v-col>
        </v-row>
    </v-form>
</template>

<script setup>
import { ref } from 'vue';
import { addContact } from '@/services/contactService';

const emit = defineEmits(['contact-added', 'error']);

const name = ref('');
const phone = ref('');

const addContactAction = async () => {
    emit('error', '');
    try {
        await addContact({ name: name.value, phone: phone.value });
        name.value = '';
        phone.value = '';
        emit('contact-added');
    } catch (error) {
        emit('error', error?.response?.data?.error || 'An error ocurred');
    }
};
</script>