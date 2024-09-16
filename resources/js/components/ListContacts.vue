<template>
    <v-data-table-server
        v-model:items-per-page="itemsPerPage"
        v-model:page="page"
        :headers="headers"
        :items="contacts"
        :items-length="totalItems"
        :loading="loading"
        :search="searchQuery"
        item-value="name"
        @update:options="fetchContacts"
        class="contacts-table"
    >
        <template v-slot:top>
            <v-text-field
                v-model="searchQuery"
                label="Search"
                outlined
                dense
                clearable
            ></v-text-field>
        </template>

        <template v-slot:item="{ item }">
            <tr>
                <td class="align-items-center">
                    <v-icon small left color="primary" class="mr-2"
                        >mdi-account</v-icon
                    >
                    {{ item.name }}
                </td>
                <td class="align-items-center">
                    <v-icon small left color="primary" class="mr-2"
                        >mdi-phone</v-icon
                    >
                    {{ item.phone }}
                </td>
                <td class="text-center">
                    <v-btn
                        color="red"
                        icon
                        @click="deleteContact(item.id)"
                        class="delete-btn align-items-center"
                        small
                    >
                        <v-icon small>mdi-delete</v-icon>
                    </v-btn>
                </td>
            </tr>
        </template>
    </v-data-table-server>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { getContacts, deleteContact as deleteContactService } from '@/services/contactService';

const emit = defineEmits(['error']);

const props = defineProps({
    refreshKey: {
        type: Number,
        default: 0
    }
});

const page = ref(1);
const itemsPerPage = ref(10);

const headers = [
    { title: 'Name', value: 'name' },
    { title: 'Phone Number', value: 'phone' },
    { title: 'Actions', value: 'actions', sortable: false },
];

const contacts = ref([]);
const totalItems = ref(0);
const loading = ref(true);
const searchQuery = ref('');

const fetchContacts = async () => {
    loading.value = true;
    try {
        const { data, total } = await getContacts(page.value, itemsPerPage.value, searchQuery.value);
        console.log(total);
        contacts.value = data;
        totalItems.value = total;
    } catch (error) {
        emit('error', error?.response?.data?.error || 'An error ocurred');
    } finally {
        loading.value = false;
    }
};

const deleteContact = async (id) => {
    try {
        await deleteContactService(id);
        fetchContacts();
    } catch (error) {
        emit('error', error?.response?.data?.error || 'An error ocurred');
    }
};

onMounted(fetchContacts);
watch(() => props.refreshKey, fetchContacts);
</script>
