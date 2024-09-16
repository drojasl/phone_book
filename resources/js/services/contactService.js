import axios from 'axios';

const API_URL = import.meta.env.VITE_APP_API_URL;

export const getContacts = async (page, itemsPerPage, searchQuery) => {
    const response = await axios.get(`${API_URL}/contacts`, {
        params: { page, per_page: itemsPerPage, search: searchQuery }
    });
    console.log(response.data);
    return response.data;
};
  
export const addContact = async (contact) => {
    return await axios.post(`${API_URL}/contacts`, contact);
};
  
export const deleteContact = async (contactId) => {
    return await axios.delete(`${API_URL}/contacts/${contactId}`);
};