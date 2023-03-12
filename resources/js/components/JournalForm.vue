<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }} -> Journals -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Date</label>
                <input type="date" id="date" class="form-control" v-model="journal.date">
            </div>
            <div class="form-group">
                <label for="name">Text</label>
                <vue-editor v-model="journal.text"/>
            </div>

            <div class="text-right">
                <a :href="`/clients/${client.id}`" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'JournalForm',

    props: ['client'],
    data() {
        return {
            journal: {
                date: '',
                text: ''
            },
        }
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then((response) => {
                    if (response.status == 200) {
                        window.location.href = response.data.url;
                    }
                }).catch(function (error) {
                if (error.response.status == 422) {
                    // TODO::need to show errors in the specific fields
                    alert(error?.response?.data?.message);
                }
            });
        }
    }
}
</script>
