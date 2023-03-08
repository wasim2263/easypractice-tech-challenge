<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary">+ New Client</a>
        </h1>

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Number of Bookings</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(client,index) in clientList" :key="client.id">
                <td>{{ client.name }}</td>
                <td>{{ client.email }}</td>
                <td>{{ client.phone }}</td>
                <td>{{ client.bookings_count }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                    <button class="btn btn-danger btn-sm" @click="deleteClient(client, index)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',

    props: ['clients'],
    data() {
        return {
            clientList: this.clients
        }
    },
    methods: {
        deleteClient(client, index) {
            axios.delete(`/clients/${client.id}`)
                .then((response) => {
                    if (response.status == 200) {
                        if (client.id == response?.data?.client_id) {
                            this.clientList.splice(index, 1)
                            alert(response?.data?.message)
                        }
                    }
                }).catch(function (error) {
                if (error.response.status == 404) {
                    alert(error?.response?.data?.message);
                }
            });
        }
    }
}
</script>
