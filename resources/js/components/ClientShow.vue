<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                        <tr>
                            <th class="text-gray-600 pr-3">Name</th>
                            <td>{{ client.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Email</th>
                            <td>{{ client.email }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Phone</th>
                            <td>{{ client.phone }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Address</th>
                            <td>{{ client.address }}<br/>{{ client.postcode }} {{ client.city }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn"
                            :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}"
                            @click="switchTab('bookings')">Bookings
                    </button>
                    <button class="btn"
                            :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}"
                            @click="switchTab('journals')">Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>
                    <select v-model="selectedBookingFilter" @change="updateList()">
                        <option v-for="bookingFilterOption in bookingFilterOptions" :value="bookingFilterOption.value">
                            {{ bookingFilterOption.title }}
                        </option>
                    </select>
                    <template v-if="filteredBookings && filteredBookings.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="booking in filteredBookings" :key="booking.id">
                                <td>{{ booking.booking_time }}</td>
                                <td>{{ booking.notes }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals</h3>
                    <a :href="journalCreateUrl" class=" btn btn-primary">+ New Journal</a>
                    <template v-if="journals && journals.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Text</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(journal,index) in journals" :key="journal.id">
                                <td>{{ journal.formatted_date }}</td>
                                <td>
                                    <span v-if="journal.text.length> 50">{{
                                            journal.text.substring(0, 50) + "..."
                                        }}</span>
                                    <span v-else>{{ journal.text.substring(0, 50) }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" @click="viewJournal(journal)">view
                                    </button>
                                    <button class="btn btn-danger btn-sm" @click="deleteJournal(journal, index)">Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no journals.</p>
                    </template>
                </div>
            </div>
        </div>

        <!-- Modal toggle -->
        <div
            v-show="isModalOpen"
            class="
          absolute
          inset-0
          flex
          items-center
          justify-center
          bg-gray-700 bg-opacity-50
        "
        >
            <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl">{{ selectedJournal.formatted_date }}</h3>
                    <svg
                        @click="isModalOpen = false"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-red-900 cursor-pointer"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
                <div class="mt-4">
                    <div v-html="selectedJournal.text">{{selectedJournal.text}}</div>
                    <button
                        @click="isModalOpen = false"
                        class="px-6 py-2 text-blue-800 border border-blue-600 rounded"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            filteredBookings: this.client.bookings,
            journals: this.client.journals,
            bookingFilterOptions: [
                {title: 'All bookings', value: 'all'},
                {title: 'Future bookings only', value: 'future'},
                {title: 'Past bookings only"', value: 'past'}
            ],
            selectedBookingFilter: 'all',
            isModalOpen: false,
            selectedJournal: {
                text: "",
                formatted_date: ""
            },
            journalCreateUrl: `/clients/${this.client.id}/journals/create`
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        updateList() {
            const currentDateTime = (new Date()).getTime();
            if (this.selectedBookingFilter === "future") {
                this.filteredBookings = this.client.bookings.filter(
                    booking => {
                        const startDateTime = (new Date(booking.start)).getTime();
                        return startDateTime > currentDateTime;
                    }
                )
            } else if (this.selectedBookingFilter === "past") {

                this.filteredBookings = this.client.bookings.filter(
                    booking => {
                        const startDateTime = (new Date(booking.start)).getTime();
                        return startDateTime < currentDateTime;
                    })
            } else {
                this.filteredBookings = this.client.bookings;
            }
        },
        deleteJournal(journal, index) {
            console.log(journal)
            axios.delete(`/clients/${journal.client_id}/journals/${journal.id}`).then((response) => {
                if (response.status == 200) {
                    if (journal.id == response?.data?.journal_id) {
                        this.journals.splice(index, 1)
                        alert(response?.data?.message)
                    }
                }
            }).catch(function (error) {
                if (error.response.status == 404) {
                    alert(error?.response?.data?.message);
                }
            });
        },
        viewJournal(journal) {
            this.isModalOpen = true;
            this.selectedJournal = journal;
        },


    }
}
</script>
